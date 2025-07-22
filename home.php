<?php get_header(); ?>
<div class="content">
    <div class="home__container-title">
        <h2 class="home__title">Dove si va?</h2>
    </div>
    <div class="home__container-categories">
        <div class="home__container-single-category box-shadow-green">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="<?= get_site_url(); ?>/wp-content/uploads/alberi-sotto-le-nuvole-durante-l-alba.webp" alt="Alberi coperti dalle nuvole durante l'alba" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">Esperienze</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">Le mie esperienze. Sono semplicemente i passi che ho mosso e le strade...</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="<?= get_site_url(); ?>/category/esperienze">
                            <button class="button button__black">Scopri di più</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__container-single-category box-shadow-blue">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="<?= get_site_url(); ?>/wp-content/uploads/muro-di-mattoni-con-la-scritta-live-work-create.webp" alt="Muro di mattoni con la scritta in inglese 'Live, Work, Create', i mattoni hanno un coloro marrone e la scritta è bianca, tutta in maiuscolo, una parola sotto l'altra" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">Opportunità</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">A volte, cambiare vita richiede solo di scoprire che esistono strade che...</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="<?= get_site_url(); ?>/category/opportunita">
                            <button class="button button__black">Nuove opportunità</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home__container-categories">
        <div class="home__container-single-category box-shadow-red">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="<?= get_site_url(); ?>/wp-content/uploads/shard-di-londra.webp" alt="Shard di Londra, l'imponente grattacielo a vetri in risalo su uno scatto della città fatto dall'alto" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">Vivere all'estero</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">Cambiare vita e andare a vivere all'estero è un viaggio che mette alla...</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="<?= get_site_url(); ?>/category/vivere-estero">
                            <button class="button button__black">Scopri di più</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__container-single-category box-shadow-yellow">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="<?= get_site_url(); ?>/wp-content/uploads/quaderno-scritto-con-penna.webp" alt="Quaderno scritto con penna, sopra appoggiata una penna e una piccola agenda, aperta su una pagina bianca dove si posa una matita" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">Chi sono</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">Mi chiamo Marco Valeri, Software Engineer, blogger, aspirante autore...</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="<?= get_site_url(); ?>/chi-sono/">
                            <button class="button button__black">Scopri di più</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home__container-serach">
        <div class="search-input">
            <h2 class="search-input__title h2">Cerca su MarcoValeri.net</h2>
            <?php get_search_form(); ?>
        </div>
    </div>
    <section class="articles-list">
        <div class="articles-list__title">
            <h1>Ultimi articoli</h1>
        </div>
        <?php
        $argsPost = [
            "post_type"         => "post",
            "posts_per_page"    => 10,
            "order"             => "DESC",
            "post_status"       => "publish"
        ];

        $lastPostQuery = new WP_Query($argsPost);
        
        if ($lastPostQuery->have_posts()) {
            while ($lastPostQuery->have_posts()) {
                $lastPostQuery->the_post();

                $lastPostLink = get_permalink();
                $lastPostCategory = get_the_category();
                $lastPostImageUrl = get_the_post_thumbnail_url();
                $lastPostImageAlt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
                $lastPostTitle = get_the_title();
                $lastPostContent = get_the_content();
                $lastPostExcerp = substr($lastPostContent, 0, 200);
                $lastPostExcerpNoHTML = strip_tags($lastPostExcerp);
                ?>
                <a class="articles-list__container no-link" href="<?= $lastPostLink; ?>">
                    <article class="articles-list__article <?= getCategoryBoxShadow($lastPostCategory[0]->name); ?>">
                        <div class="articles-list__container-image">
                            <img class="articles-list__article-image" src="<?= $lastPostImageUrl; ?>" alt="<?= $lastPostImageAlt; ?>">
                        </div>
                        <div class="articles-list__content-container">
                            <h1 class="articles-list__article-title"><?= $lastPostTitle; ?></h1>
                            <div class="articles-list__article-paragraph"><?= $lastPostExcerpNoHTML; ?></div>
                        </div>
                    </article>
                </a>
                <?php
            }
            wp_reset_postdata();
        }
        ?>
    </section>
</div>
<?php get_footer(); ?>