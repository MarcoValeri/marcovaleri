<?php
/**
 * Custom callback function to format the HTML for each comment.
 * This version checks if the commenter is an admin and displays their
 * name as plain text instead of a link.
 */
function my_custom_comment_format($comment, $args, $depth) {
    // Create an array to hold our classes.
    $custom_classes = ['comment-card'];

    // If the depth is greater than 1, it's a reply.
    if ($depth > 1) {
        $custom_classes[] = 'comment-card--reply';
    }
    ?>
    <div <?php comment_class($custom_classes); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-card__wrapper">
            <div class="comment-card__container-name">
                <h4 class="h3">
                    <?php
                    // --- START: NEW LOGIC FOR AUTHOR NAME ---
                    // Check if the comment was written by a logged-in user with the 'administrator' role.
                    if ($comment->user_id && user_can($comment->user_id, 'administrator')) {
                        // If they are an admin, just print their name without a link.
                        echo get_comment_author($comment);
                    } else {
                        // For all other users and guests, use the default link behavior.
                        echo get_comment_author_link($comment);
                    }
                    // --- END: NEW LOGIC ---
                    ?>
                </h4>
            </div>

            <div class="comment-card__container-date">
                <h5 class="body-4">
                    Pubblicato il <?php printf('%1$s', get_comment_date('d-m-Y')); ?>
                </h5>
            </div>

            <?php if ('0' == $comment->comment_approved) : ?>
                <p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>
            <?php endif; ?>

            <div class="comment-card__container-comment">
                <?php comment_text(); ?>
            </div>

            <div class="comment-card__reply">
                <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        [
                            'add_below'  => 'comment',
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => 'Rispondi',
                            'login_text' => 'Log in to Reply'
                        ]
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <?php
}
