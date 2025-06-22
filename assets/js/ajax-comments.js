document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Element Selectors ---
    const commentForm = document.getElementById('commentform');
    const mainSuccessMessage = document.getElementById('comment-success-message');
    const replySuccessMessage = document.getElementById('reply-success-message');
    const submitButton = document.getElementById('comment-submit');
    const commentsContainer = document.querySelector('.content__container-comments');

    if (!commentForm) {
        return;
    }

    // --- 2. Rich Text Editor (TinyMCE) Handling (No Changes Here) ---
    const tinyMceSettings = {
        selector: '#comment',
        menubar: false,
        teeny: true,
        toolbar: 'bold italic strikethrough | bullist numlist | link unlink',
        plugins: 'lists, wplink, paste',
        paste_as_text: true,
        media_buttons: false,
        quicktags: false,
        textarea_rows: 8,
    };
    function reinitializeEditor() {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#comment');
            tinymce.init(tinyMceSettings);
        }
    }
    if (commentsContainer) {
        commentsContainer.addEventListener('click', function(e) {
            if (e.target.matches('.comment-reply-link')) {
                setTimeout(reinitializeEditor, 50);
            }
        });
    }
    commentForm.addEventListener('click', function(e) {
        if (e.target.matches('#cancel-comment-reply-link')) {
             if (typeof tinymce !== 'undefined') {
                tinymce.remove('#comment');
            }
        }
    });

    // --- 3. Main Form Submission Logic ---
    const errorContainers = commentForm.querySelectorAll('.content__form-error');
    commentForm.addEventListener('submit', e => {
        e.preventDefault();

        // A. Reset UI State
        errorContainers.forEach(container => { container.style.display = 'none'; });
        mainSuccessMessage.style.display = 'none';
        replySuccessMessage.style.display = 'none';
        if (submitButton) {
            submitButton.value = 'Invio in corso...';
            submitButton.disabled = true;
        }
        if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
            tinymce.get('comment').save();
        }

        // B. Prepare and Send Data
        const formData = new FormData(commentForm);
        const parentIdInput = document.getElementById('comment_parent');
        if (parentIdInput) {
            formData.set('comment_parent', parentIdInput.value);
        }
        const commentDataString = new URLSearchParams(formData).toString();
        const bodyParams = new URLSearchParams();
        bodyParams.append('action', 'submit_ajax_comment');
        bodyParams.append('nonce', comments_ajax_obj.nonce);
        bodyParams.append('comment_data', commentDataString);

        // C. Fetch API Request
        fetch(comments_ajax_obj.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: bodyParams
        })
        .then(response => response.json())
        .then(data => {
            if (submitButton) {
                submitButton.value = 'Invia';
                submitButton.disabled = false;
            }

            // --- D. Handle Server Response ---
            if (data.success) {
                // SUCCESS
                const parentId = parentIdInput ? parseInt(parentIdInput.value) : 0;
                const isReply = parentId > 0;

                // On success, always hide the form
                commentForm.style.display = 'none';

                if (isReply) {
                    // This was a reply.
                    // First, move the form back to the bottom.
                    const cancelLink = document.getElementById('cancel-comment-reply-link');
                    if (cancelLink) {
                        cancelLink.click();
                    }
                    // Then, move and show the reply success message.
                    const parentCommentNode = document.getElementById('comment-' + parentId);
                    if (parentCommentNode) {
                        parentCommentNode.appendChild(replySuccessMessage);
                    }
                    replySuccessMessage.style.display = 'block';
                } else {
                    // This was a top-level comment. Just show the main success message.
                    // We do NOT click the cancel link here.
                    mainSuccessMessage.style.display = 'block';
                }
            } else {
                // VALIDATION ERROR (no changes to this part)
                if (data.data.errors) {
                    for (const field in data.data.errors) {
                        const message = data.data.errors[field];
                        if (field === 'comment') {
                            const commentWrapper = commentForm.querySelector('.content__container-form-content');
                            if (commentWrapper) {
                                const errorDiv = commentWrapper.querySelector('.content__form-error');
                                if (errorDiv) { errorDiv.textContent = message; errorDiv.style.display = 'block'; }
                            }
                        } else {
                            const inputField = commentForm.querySelector(`[name="${field}"]`);
                            if (inputField) {
                                const errorDiv = inputField.parentElement.querySelector('.content__form-error');
                                if (errorDiv) { errorDiv.textContent = message; errorDiv.style.display = 'block'; }
                            } else {
                                alert('Errore: ' + message);
                            }
                        }
                    }
                }
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Si è verificato un errore di rete. Riprova più tardi.');
            if (submitButton) { submitButton.disabled = false; }
        });
    });
});
