<?php get_header(); ?>
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $pageTitle = get_the_title();
        $pageContent = get_the_content();
        ?>
        <section>
            <div class="content__title">
                <h1><?= $pageTitle; ?></h1>
            </div>
            <div class="content__main">
                <?= $pageContent; ?>
            </div>
        </section>
        <?php
    }
}
?>
<?php get_footer(); ?>