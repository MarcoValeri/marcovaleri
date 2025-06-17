/**
 * Final Corrected AJAX Comments Script
 *
 * This version fixes the root cause: the parent comment ID was not being
 * sent correctly during reply submissions. This script now manually reads
 * the parent ID to guarantee it is included in the AJAX request.
 */
document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Element Selectors ---
    const commentForm = document.getElementById('commentform');
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
        if (submitButton) {
            submitButton.value = 'Invio in corso...';
            submitButton.disabled = true;
        }
        if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
            tinymce.get('comment').save();
        }

        // --- B. Prepare and Send Data (THE CRITICAL FIX IS HERE) ---
        const formData = new FormData(commentForm);

        // **THE FIX**: Manually read the parent ID from the hidden input.
        // This is more reliable than letting FormData do it after the DOM has been changed.
        const parentIdInput = document.getElementById('comment_parent');
        if (parentIdInput) {
            formData.set('comment_parent', parentIdInput.value);
        }

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

            if (data.success) {
                // SUCCESS: Reload the page to show the new comment structure correctly.
                // This is the simplest and most reliable way to update the view.
                window.location.reload();

            } else {
                // VALIDATION ERROR
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
