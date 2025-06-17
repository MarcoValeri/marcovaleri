document.addEventListener('DOMContentLoaded', () => {

    const commentForm = document.getElementById('commentform');
    const successMessage = document.getElementById('comment-success-message');
    const submitButton = document.getElementById('comment-submit');

    if (!commentForm) {
        return;
    }

    const errorContainers = commentForm.querySelectorAll('.content__form-error');

    commentForm.addEventListener('submit', e => {
        e.preventDefault();

        errorContainers.forEach(container => {
            container.textContent = '';
            container.style.display = 'none';
        });

        if (submitButton) {
            submitButton.value = 'Invio in corso...';
            submitButton.disabled = true;
        }

        if (typeof tinymce !== 'undefined' && tinymce.get('comment')) {
            tinymce.get('comment').save();
        }

        const formData = new FormData(commentForm);
        const commentDataString = new URLSearchParams(formData).toString();

        const bodyParams = new URLSearchParams();
        bodyParams.append('action', 'submit_ajax_comment');
        bodyParams.append('nonce', comments_ajax_obj.nonce);
        bodyParams.append('comment_data', commentDataString);

        fetch(comments_ajax_obj.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: bodyParams
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (submitButton) {
                    submitButton.value = 'Invia';
                    submitButton.disabled = false;
                }

                if (data.success) {
                    commentForm.style.display = 'none';
                    successMessage.style.display = 'block';
                } else {
                    if (data.data.errors) {
                        for (const field in data.data.errors) {
                            const message = data.data.errors[field];
                            if (field === 'comment') {
                                const commentWrapper = commentForm.querySelector('.content__container-form-content');
                                if (commentWrapper) {
                                    const errorDiv = commentWrapper.querySelector('.content__form-error');
                                    if (errorDiv) {
                                        errorDiv.textContent = message;
                                        errorDiv.style.display = 'block';
                                    }
                                }
                            }
                            else {
                                const inputField = commentForm.querySelector(`[name="${field}"]`);
                                if (inputField) {
                                    const errorDiv = inputField.parentElement.querySelector('.content__form-error');
                                    if (errorDiv) {
                                        errorDiv.textContent = message;
                                        errorDiv.style.display = 'block';
                                    }
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
                if (submitButton) {
                    submitButton.value = 'Invia';
                    submitButton.disabled = false;
                }
            });
    });
});