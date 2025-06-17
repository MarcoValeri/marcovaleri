<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX request for comment submission
 */
function submit_ajax_comment() {
    if (!wp_verify_nonce($_POST['nonce'], 'comment_nonce')) {
        wp_send_json_error(['message' => 'Nonce verification failed.'], 403);
    }

    parse_str($_POST['comment_data'], $comment_data);

    $errors = [];

    $author = isset($comment_data['author']) ? esc_html($comment_data['author']) : '';
    if (empty($author)) {
        $errors['author'] = 'Il campo nome è obbligatorio.';
    }

    $email = isset($comment_data['email']) ? esc_html($comment_data['email']) : '';
    if (empty($email)) {
        $errors['email'] = 'Il campo email è obbligatorio.';
    } else if (!is_email($email)) {
        $errors['email'] = 'Per favore, inserisci un indirizzo email valido.';
    }

    $comment_content = isset($comment_data['comment']) ? wp_kses_post($comment_data['comment']) : '';
    if (empty($comment_content)) {
        $errors['comment'] = 'Il campo commento non può essere vuoto.';
    }

    $post_id = isset($comment_data['comment_post_ID']) ? intval($comment_data['comment_post_ID']) : 0;
    if ( empty($post_id) ) {
        $errors['form'] = 'Si è verificato un errore, impossibile identificare l\'articolo.';
    }

    if (!empty($errors)) {
        wp_send_json_error(['errors' => $errors], 400);
    }

    // Safer variable handling with isset() checks
    $commentdata = [
        'comment_post_ID'      => isset($comment_data['comment_post_ID']) ? intval($comment_data['comment_post_ID']) : 0,
        'comment_author'       => isset($comment_data['author']) ? esc_html($comment_data['author']) : '',
        'comment_author_email' => isset($comment_data['email']) ? esc_html($comment_data['email']) : '',
        'comment_author_url'   => '',
        'comment_content'      => isset($comment_data['comment']) ? wp_kses_post($comment_data['comment']) : '',
        'user_id'              => get_current_user_id(),
        'comment_type'         => '',
        'comment_parent'       => isset($comment_data['comment_parent']) ? intval($comment_data['comment_parent']) : 0,
    ];

    $comment_id = wp_new_comment($commentdata);

    if (is_wp_error( $comment_id)) {
        wp_send_json_error(['errors' => ['form' => 'Il commento non può essere salvato.']], 500);
    }

    wp_send_json_success(['message' => 'Comment submitted successfully.']);

    wp_die();
}
add_action('wp_ajax_nopriv_submit_ajax_comment', 'submit_ajax_comment');
add_action('wp_ajax_submit_ajax_comment', 'submit_ajax_comment');