<?php get_header(); ?>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();

            $postID = get_the_ID();
            $postTitle = get_the_title();
            $postDate = get_the_date('d-m-Y');
            $postUpdateDate = get_the_modified_date('d-m-Y');
            $postCommentsNum = get_comments_number();
            $postContent = get_the_content();
        }
    }
    ?>
    <article>
        <div class="content__title">
            <h1><?= $postTitle; ?></h1>
        </div>
        <div class="content__data">
            <ul class="list-no-style">
                <li class="content__data-item">Autore: Marco Valeri</li>
                <li class="content__data-item">Pubblicato il: <?= $postDate; ?></li>
                <li class="content__data-item">Ultima modifica: <?= $postUpdateDate; ?></li>
                <li class="content__data-item">Commenti: <?= $postCommentsNum; ?></li>
            </ul>
        </div>
        <div class="content__main">
            <?= $postContent; ?>
        </div>
        <section>
            <div class="banner-author">
                <div class="banner-author__wrapper">
                    <div class="banner-author__container-image">
                        <img class="banner-author__image" src="<?= get_site_url(); ?>/wp-content/uploads/marco-valeri-conferenza-di-bristol-uk.webp" alt="Immagine dell'autore Marco Valeri ad una conferenza a Bristol" />
                    </div>
                    <div class="banner-author__container-content">
                        <h4 class="banner-author__title h3">Marco Valeri</h4>
                        <p class="banner-author__description p">Mi chiamo Marco Valeri, sono nato a Roma e attualmente vivo a Londra, città che mi ha cambiato la vita.<br /><br />Laureato in Computer Science alla Birkbeck University of London, divoro libri, amo scrivere e non mi stanco mai di conoscere cose nuove, soprattutto legate al mondo dell'informatica.<br /><br />Ogni giorno provo a mettere in atto il concetto secondo cui 'La disciplina è libertà'.</p>
                    </div>
                </div>
            </div>
        </section>
        <?php
        if (comments_open()) {
            comments_template();
        }
        ?>
    </article>
<?php get_footer(); ?>