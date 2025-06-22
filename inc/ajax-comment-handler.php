<?php
/**
 * Final Corrected AJAX Comment Handler
 * This version adds a check to see if a user is logged in. If they are,
 * it skips the validation for the author and email fields, as WordPress
 * gets this information automatically.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Handle AJAX request for comment submission.
 */
function submit_ajax_comment() {
    if (!wp_verify_nonce($_POST['nonce'], 'comment_nonce')) {
        wp_send_json_error(['errors' => ['form' => 'Nonce verification failed.']], 403);
    }

    parse_str($_POST['comment_data'], $comment_data);

    $errors = [];
    $user_is_logged_in = is_user_logged_in();

    // --- START: Updated Validation ---

    // Only validate author and email if the user is NOT logged in.
    if (!$user_is_logged_in) {
        $author = isset($comment_data['author']) ? esc_html(trim($comment_data['author'])) : '';
        if (empty($author)) {
            $errors['author'] = 'Il campo nome è obbligatorio.';
        }

        $email = isset($comment_data['email']) ? esc_html(trim($comment_data['email'])) : '';
        if (empty($email)) {
            $errors['email'] = 'Il campo email è obbligatorio.';
        } elseif (!is_email($email)) {
            $errors['email'] = 'Per favore, inserisci un indirizzo email valido.';
        }
    }

    // Always validate the comment content.
    $comment_content = isset($comment_data['comment']) ? wp_kses_post(trim($comment_data['comment'])) : '';
    if (empty($comment_content)) {
        $errors['comment'] = 'Il campo commento non può essere vuoto.';
    }
    
    // Always validate the post ID.
    $post_id = isset($comment_data['comment_post_ID']) ? intval($comment_data['comment_post_ID']) : 0;
    if (empty($post_id)) {
        $errors['form'] = 'Si è verificato un errore, impossibile identificare l\'articolo.';
    }

    // --- END: Updated Validation ---

    if (!empty($errors)) {
        wp_send_json_error(['errors' => $errors], 400);
    }

    // Prepare comment data for insertion
    $commentdata = [
        'comment_post_ID'      => $post_id,
        'comment_content'      => $comment_content,
        'comment_parent'       => isset($comment_data['comment_parent']) ? intval($comment_data['comment_parent']) : 0,
        'user_id'              => get_current_user_id(),
        'comment_type'         => '',
    ];

    // If the user is not logged in, add their name and email to the data array.
    if (!$user_is_logged_in) {
        $commentdata['comment_author']       = $author;
        $commentdata['comment_author_email'] = $email;
    }

    // Insert the comment into the database
    $comment_id = wp_new_comment($commentdata);

    if (is_wp_error($comment_id)) {
        wp_send_json_error(['errors' => ['form' => 'Il commento non può essere salvato.']], 500);
    }

    wp_send_json_success(['message' => 'Comment submitted successfully.']);

    wp_die();
}
add_action('wp_ajax_nopriv_submit_ajax_comment', 'submit_ajax_comment');
add_action('wp_ajax_submit_ajax_comment', 'submit_ajax_comment');
