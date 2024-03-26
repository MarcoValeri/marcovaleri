<?php get_header(); ?>
<div class="content">
    <div class="content__title">
        <h2>Lascia che mi presenti</h2>
    </div>
    <div class="content__main">
        <p>
            Mi chiamo Marco Valeri e voglio darti il benvenuto nel mio sito, che raccoglie tutti i miei pensieri e le mie idee, quelle che mi hanno fatto arrivare a raggiungere alcuni dei miei sogni pur essendo partito dal basso.
            <br><br>
            Sono nato a Roma nel 1984, una città che ho amato e odiato allo stesso tempo, un luogo che racchiude tante emozioni e persone che hanno fatto e che fanno ancora parte della mia vita.
            <br><br>
            A trent’anni mi sono trasferito a vivere a Londra, città che mi ha cambiato letteralmente la vita.
            <br><br>
            I nostri nonni partivano con la valigia di cartone verso il Nord Italia, il Nord Europa o verso gli Stati Uniti d’America. Io, invece, sono partito con un volo low cost, pochi soldi e con una valigia piena di voglia di riscatto.
            <br><br>
            Andare via dall’Italia mi ha fatto mettere un punto sul passato per ripartire completamente da zero, Londra è stato il luogo giusto in cui farlo, nonostante avessi più di trent’anni, un’età per cui per molti ero ormai troppo vecchio per avere una vita diversa, quella che realmente volevo.
            <br><br>
            Ripartire da zero fa paura, soprattutto quando...<a href="/">[Continua a leggere...]</a>
        </p>
    </div>
    <div class="home__container-categories">
        <div class="home__container-single-category">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="#" alt="#" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">BANNER PREVIEW TITLE</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">Banner preview description</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="{{ bannerPreviewLink }}">
                            <button class="button button__black">Buttons</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__container-single-category">
            <div class="banner-preview">
                <div class="banner-preview__wrapper">
                    <div class="banner-preview__container-image">
                        <img class="banner-preview__image" src="#" alt="#" />
                    </div>
                    <div class="banner-preview__container-title">
                        <h2 class="h2">Banner preview title</h2>
                    </div>
                    <div class="banner-preview__container-description">
                        <p class="body-2">Banner preview description</p>
                    </div>
                    <div class="banner-preview__container-button">
                        <a href="{{ bannerPreviewLink }}">
                            <button class="button button__black">Banner preview btn</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="articles-list">
        <div class="articles-list__title">
            <h1>Ultimi articoli</h1>
        </div>
        <a class="articles-list__container no-link" href="#">
            <article class="articles-list__article">
                <div class="articles-list__container-image">
                    <img class="articles-list__article-image" src="#" alt="#">
                </div>
                <div class="articles-list__content-container">
                    <h1 class="articles-list__article-title">ARTICLE TITLE</h1>
                    <div class="articles-list__article-paragraph">ARTICLE INTRO</div>
                </div>
            </article>
        </a>
    </section>
    <section class="home__container-button">
        <a href="#">
            <button class="button button__black">Scopri tutti gli articoli</button>
        </a>
    </section>
</div>
<?php get_footer(); ?>