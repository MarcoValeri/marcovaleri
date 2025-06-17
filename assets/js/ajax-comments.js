/**
 * Final AJAX Comments Script for WordPress (Corrected)
 *
 * This script handles the entire comment submission process without a page reload.
 * Features include:
 * - AJAX form submission using vanilla JavaScript (Fetch API).
 * - Inline error messages for failed validation (no alerts).
 * - Fixes the rich text editor (TinyMCE) when replying to comments.
 * - Shows a different success message for replies vs. new comments.
 * - Moves the reply success message to appear directly under the parent comment.
 */
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

    // --- 2. Rich Text Editor (TinyMCE) Handling ---
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
        const commentDataString = new URLSearchParams(formData).toString();
        const bodyParams = new URLSearchParams();
        bodyParams.append('action', 'submit_ajax_comment');
        bodyParams.append('nonce', comments_ajax_obj.nonce);
        bodyParams.append('comment_data', commentDataString);

        // --- C. Fetch API Request ---
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
                const commentParentInput = document.getElementById('comment_parent');
                // ** THE FIX IS HERE: Capture the ID *before* the form resets **
                const parentId = commentParentInput ? parseInt(commentParentInput.value) : 0;
                const isReply = parentId > 0;

                // On success, always hide the form
                commentForm.style.display = 'none';

                // Move the form back to the bottom. This must happen *after* we get the parentId.
                const cancelLink = document.getElementById('cancel-comment-reply-link');
                if (cancelLink) {
                    cancelLink.click();
                }
                
                if (isReply) {
                    // This was a reply, so move and show the reply success message
                    const parentCommentNode = document.getElementById('comment-' + parentId); // Use the captured parentId
                    if (parentCommentNode) {
                        parentCommentNode.appendChild(replySuccessMessage);
                    }
                    replySuccessMessage.style.display = 'block';
                } else {
                    // This was a top-level comment, show the main success message
                    mainSuccessMessage.style.display = 'block';
                }

            } else {
                // VALIDATION ERROR (no changes here)
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
