<?php
require get_template_directory() . '/inc/ajax-comment-handler.php';

// Add theme support
add_theme_support('post-thumbnails', ['post', 'page']);
add_theme_support('editor-styles');
add_theme_support('wp-block-styles');

// Load JS and CSS files
function mv_enqueue_script()
{
    wp_enqueue_style("style-css", get_template_directory_uri() . "/style.css", false, "1.1", "all");
    wp_enqueue_style("main-css", get_template_directory_uri() . "/assets/css/main.css", false, "1.1", "all");

    if (is_single()) {
        wp_enqueue_script("newsletter-banner-js", get_template_directory_uri() . "/assets/js/newsletter-banner.js", [], 1, true);

        // Enqueue AJAX comments scripts
        wp_enqueue_script(
            'ajax-comments',
            get_template_directory_uri() . '/assets/js/ajax-comments.js',
            [],
            '1.1',
            true
        );

        wp_localize_script('ajax-comments', 'comments_ajax_obj', [
            'ajax_url'  => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('comment_nonce')
        ]);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action("wp_enqueue_scripts", "mv_enqueue_script");

/**
 * Create a function that able rich text editor for comments
 */
function enable_rich_text_in_comments($comment_field)
{
    ob_start();

    $editor_settings = [
        'media_buttons' => false,
        'teeny'         => true,
        'quicktags'     => false,
        'textarea_rows' => 8,
        'textarea_name' => 'comment',
        'editor_class'  => 'content__input-textarea',
        'tinymce'       => [
            'toolbar1' => 'bold, italic, strikethrough, bullist, numlist, link, unlink',
            'plugins'  => 'lists, wplink, paste',
            'paste_as_text' => true,
        ],
    ];

    wp_editor('', 'comment', $editor_settings);

    $editor = ob_get_clean();
    $comment_field = '<div class="content__container-form-content">' . $editor . '<div class="body-3 content__form-error"></div></div>';

    return $comment_field;
}
add_filter('comment_form_field_comment', 'enable_rich_text_in_comments');

/*
* Create a function that get
* @param string as path of url
* and
* @return bool true if
* the current path of the url
* has this path
* false otherwise
*/
function isThisUrlPath($path)
{
    if ($_SERVER['REQUEST_URI'] === $path) {
        return true;
    }
    return false;
}

/**
 * Create a function that gets
 * @param string $getCategoryName
 * as the name of the category
 * and
 * @return string as right
 * class for box-shadow
 */
function getCategoryBoxShadow($getCategoryName)
{
    $setBoxShadow = "box-shadow-yellow";
    switch ($getCategoryName) {
        case "Esperienze":
            $setBoxShadow = "box-shadow-green";
            break;
        case "Opportunità":
            $setBoxShadow = "box-shadow-blue";
            break;
        case "Vivere all'estero":
            $setBoxShadow = "box-shadow-red";
            break;
        case "Scrivere":
            $setBoxShadow = "box-shadow-yellow";
        default:
            $setBoxShadow = "box-shadow-yellow";
    }
    return $setBoxShadow;
}

/**
 * Create a function that redirect a user
 * after the submittion of the comment
 * form
 */
function add_parameter_after_comment_submission($location)
{
    $addParamterToTheURL = 'article-container-comments';

    if (false === strpos($location, $addParamterToTheURL)) {
        $location = add_query_arg('article-container-comments', 'value', $location);
    }

    return $location;
}
add_filter('comment_post_redirect', 'add_parameter_after_comment_submission');

/**
 * Custom callback function to format the HTML for each comment.
 * This is used by wp_list_comments() in comments.php.
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
                    <h4 class="h3"><?php echo get_comment_author_link(); ?></h4>
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
                                'reply_text' => 'Rispondi', // "Reply" text
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
