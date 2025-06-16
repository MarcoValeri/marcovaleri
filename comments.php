<?php
$commentsNum = get_comments_number();
$postID = get_post()->ID;
$postURL = get_post_permalink($postID);
?>
<section id="article-container-comments" class="content__section-form">
    <?php
    // Show successfull message if the comment has been sent
    if (count($_GET) > 0) {
        if ($_GET['unapproved']) {
            echo '<div class="content__container-comments-success"><p class="content__success-message body-2">Grazie per lasciato la tua opinione. Commento in fase di approvazione</p></div>';
        }
    }
    ?>
    <div class="content__form-header">
        <h3 class="h2">Lascia un commento</h3>
    </div>
    <?php
    // Set up comments form and print it out
    $userEmailLogged = wp_get_current_user()->user_email;
    $argsComment = [
        'fields' => [
            'author'    => '<div class="content__container-form-name"><input class="content__input-text input-text" type="text" id="author" name="author" placeholder="Nome *" required /><div class="body-3 content__form-error"></div></div>',
            'email'     => '<div class="content__container-form-email"><input class="content__input-text content__input-email input-text" type="email" id="email" name="email" placeholder="Email *" required /><p class="body-3">La tua email non verrà pubblicata</p><div class="body-3 content__form-error"></div></div>',
            'cookies'   => '<div class="content__container-form-privacy"><input class="input-checkbox" type="checkbox" id="Privacy" name="Privacy" required="required" value="1"><label class="content__label-privacy body-2" for="Privacy">Accetto la privacy policy</label></div><div class="article__form-comments-submit article__input"></div>'
        ],
        'submit_button'             => '<div class="content__container-form-submit"><input class="content__form-btn button button__black" type="submit" name="submit" value="Invia" /><p class="body-3">Per maggiori informazioni consulta la <a class="link" href="#">Privacy Policy</a></p></div>',
        'title_reply'               => __(''),
        'title_reply_to'            => __('Rispondi'),
        'logged_in_as'              => '<div><p>Sei registrato come ' . $userEmailLogged . '</p></div>',
        'comment_notes_before'      => __(''),
        'comment_notes_after'       => '',
        'id_submit'                 => __('comment-submit'),
        'class_form'                => 'content__form-grid',
    ];

    comment_form($argsComment);
    ?>
</section>
<section class="content__container-comments">
    <div class="content__comments-header">
        <h3 class="h2"><?= $commentsNum; ?><?= $commentsNum === 1 ? " commento" : " commenti"; ?></h3>
    </div>
    <?php
    // Show approved comments
    $argsSingleComment = [
        "status"    => "approve",
        "post_id"   => $postID,
    ];

    $commentsQuery = new WP_Comment_Query();
    $getAllComments = $commentsQuery->query($argsSingleComment);

    if ($getAllComments) {
        foreach ($getAllComments as $comment) {
            ?>
            <div class="comment-card">
                <div class="comment-card__wrapper">
                    <div class="comment-card__container-name">
                        <h4 class="h3"><?= $comment->comment_author; ?></h4>
                    </div>
                    <div class="comment-card__container-date">
                        <h5 class="body-4">Pubblicato il <?= get_comment_date('d-m-Y G:i:s'); ?> da <?= $comment->comment_author; ?></h5>
                    </div>
                    <div class="comment-card__container-comment">
                        <?= $comment->comment_content; ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</section>