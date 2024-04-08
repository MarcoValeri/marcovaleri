<?php get_header(); ?>
<section class="articles-list">
    <?php
    $getSearchQuery = get_search_query();
    
    $argsQuery = [
        'post_type'         => 'post',
        's'                 => $getSearchQuery,
        'order'             => 'DESC',
        'posts_per_page'    => 10

    ];

    $searchQuery = new WP_Query($argsQuery);

    if ($searchQuery->have_posts()) {
        ?>
        <div class="articles-list__title">
            <h1>Risultati di ricerca per <?= get_search_query(); ?></h1>
        </div>
        <?php
        while ($searchQuery->have_posts()) {
            $searchQuery->the_post();
            
            $searchPostUrl = get_permalink();
            $searchPostTitle = get_the_title();
            $searchPostImageUrl = get_the_post_thumbnail_url();
            $searchPostImageAlt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
            $searchPostContent = get_the_content();
            $searchPostExcerp = substr($searchPostContent, 0, 200);
            $searchPostExcerpNoHTML = strip_tags($searchPostExcerp);
            ?>
            <a class="articles-list__container no-link" href="<?= $searchPostUrl; ?>">
                <article class="articles-list__article">
                    <div class="articles-list__container-image">
                        <img class="articles-list__article-image" src="<?= $searchPostImageUrl; ?>" alt="<?= $searchPostImageAlt; ?>">
                    </div>
                    <div class="articles-list__content-container">
                        <h1 class="articles-list__article-title"><?= $searchPostTitle; ?></h1>
                        <div class="articles-list__article-paragraph"><?= $searchPostExcerpNoHTML; ?></div>
                    </div>
                </article>
            </a>
            <?php
        }
    } else {
        ?>
        <div class="articles-list__title">
            <h1>Nessun risultato trovato con il termine <?= get_search_query(); ?></h1>
        </div>
        <?php
    }
    wp_reset_postdata();
    ?>
</section>
<?php get_footer(); ?>