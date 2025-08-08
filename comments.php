<?php
$commentsNum = get_comments_number();
?>
<section id="article-container-comments" class="content__section-form">
    <div id="comment-success-message" class="content__container-comments-success" style="display:none;">
        <p class="content__success-message body-2">Grazie per aver lasciato la tua opinione. Il tuo commento è in fase di approvazione.</p>
    </div>
    <div id="reply-success-message" class="content__container-comments-success" style="display:none;">
        <p class="content__success-message body-2">Grazie per la tua risposta. Il commento è in fase di approvazione.</p>
    </div>
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
        'submit_button'             => '<div class="content__container-form-submit"><input class="content__form-btn button button__black" type="submit" name="submit" value="Invia" id="comment-submit" /><p class="body-3">Per maggiori informazioni consulta la <a class="link" href="#">Privacy Policy</a></p></div>',
        'title_reply'               => __(''),
        'title_reply_to'            => __('Rispondi'),
        'logged_in_as'              => '<div><p class="p">Sei registrato come <strong>' . $userEmailLogged . '</strong></p></div>',
        'comment_notes_before'      => '',
        'comment_notes_after'       => '',
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
    wp_list_comments( [
        'style'       => 'div', // Use <div>s for comments instead of <ul>
        'short_ping'  => true,
        'avatar_size' => 0, // Set to 0 to hide avatars, or a size like 64
        'max_depth' => 2,
        'callback'    => 'my_custom_comment_format', // This is our custom function from functions.php
    ] );

    // This shows comment pagination if you have many comments
    paginate_comments_links();
    ?>
</section>