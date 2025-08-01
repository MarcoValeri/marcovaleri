<?php get_header(); ?>
<section class="articles-list">
    <div class="articles-list__container-description articles-list__container-description--viaggi">
        <h1 class="articles-list__title">Viaggi</h1>
        <h2 class="articles-list__description h4">Viaggiare significa aprire la propria mente verso nuovi orizzonti, culture e esperienze di vita. Credo che esista un posto per tutti nel mondo, alle volte per trovarlo bisogna mettersi in viaggio. Qui racconto le mie avventure, le piccole e grandi scoperte fatte lungo la strada.</h2>
    </div>
    <?php
    $categoryViaggiArgs = [
        "posts_per_page"    => 10,
        "category_name"     => "viaggi",
    ];

    $categoryEsperienzeQuery = new WP_Query($categoryViaggiArgs);

    if ($categoryViaggiQuery->have_posts()) {
        while ($categoryViaggiQuery->have_posts()) {
            $categoryViaggiQuery->the_post();

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