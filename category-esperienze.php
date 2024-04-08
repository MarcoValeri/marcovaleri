<?php get_header(); ?>
<section class="articles-list">
    <div class="articles-list__container-description articles-list__container-description--esperienze">
        <h1 class="articles-list__title">Esperienze</h1>
        <h2 class="articles-list__description h4">Conoscere le esperienze altrui è il modo per farle tue, per vivere più vite conteporaneamente, per non fare gli errori che hanno già fatto gli altri e per fare meglio la prossima volta</h2>
    </div>
    <?php
    $categoryEsperienzeArgs = [
        "posts_per_page"    => 10,
        "category_name"     => "esperienze",
    ];

    $categoryEsperienzeQuery = new WP_Query($categoryEsperienzeArgs);

    if ($categoryEsperienzeQuery->have_posts()) {
        while ($categoryEsperienzeQuery->have_posts()) {
            $categoryEsperienzeQuery->the_post();

            $postUrl = get_permalink();
            $postTitle = get_the_title();
            $postImageUrl = get_the_post_thumbnail_url();
            $postImageAlt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
            $postContent = get_the_content();
            $postExcerpt = substr($postContent, 0, 200);
            $postExcerptNoHTML = strip_tags($postExcerpt);
            ?>
            <a class="articles-list__container no-link" href="<?= $postUrl; ?>">
                <article class="articles-list__article">
                    <div class="articles-list__container-image">
                        <img class="articles-list__article-image" src="<?= $postImageUrl; ?>" alt="<?= $postImageAlt; ?>">
                    </div>
                    <div class="articles-list__content-container">
                        <h1 class="articles-list__article-title"><?= $postTitle; ?></h1>
                        <div class="articles-list__article-paragraph"><?= $postExcerptNoHTML; ?></div>
                    </div>
                </article>
            </a>
            <?php
        }
    }
    wp_reset_postdata();
    ?>
</section>
<?php get_footer(); ?>