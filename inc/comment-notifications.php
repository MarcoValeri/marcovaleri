<?php
/**
 * Sends an email notification to the comment author when their comment is approved.
 *
 * This function is triggered when a comment's status changes. It checks if the
 * change is from 'unapproved' to 'approved' and then sends a customized email.
 *
 * @param string     $new_status The new status of the comment ('approved', 'trash', etc.).
 * @param string     $old_status The old status of the comment.
 * @param WP_Comment $comment    The comment object.
 */
function mv_comment_notification_on_approval($new_status, $old_status, $comment) {
    // Only send an email if the comment is being approved for the first time
    if ($old_status === "unapproved" && $new_status === "approved") {
        // Get all the necessar information
        $post_id = $comment->comment_post_ID;
        $post = get_post($post_id);
        $comment_author_email = $comment->comment_author_email;
        $comment_author_name = $comment->comment_author;

        // Prepare the email subject
        $subject = "Il tuo commento su marcovaleri.net è stato approvato";

        // Prepare the email message body
        // Prepare the plain text email message body
        $message  = "Ciao " . $comment_author_name . ",\n\n";
        $message .= "Siamo felici di comunicarti che il tuo commento sull'articolo \"" . $post->post_title . "\" è stato approvato.\n\n";
        $message .= "Puoi vederlo e continuare la conversazione qui:\n";
        $message .= get_comment_link($comment) . "\n\n";
        $message .= "Grazie per aver partecipato alla discussione.\n\n";
        $message .= "Saluti,\n";
        $message .= "Il team di marcovaleri.net";

        // Set email headers for plain text content type
        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        // Send the email using WordPress's mail function
        wp_mail($comment_author_email, $subject, $message, $headers);
    }
}
add_action('transition_comment_status', 'mv_comment_notification_on_approval', 10, 3);