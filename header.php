<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title(); ?></title>

    <?php if (isThisUrlPath("/")) {
        echo '<meta name="Description" CONTENT="Marco Valeri, autore, blogger, web developer, sito ufficiale con gli articoli di crescita personale, professionale, i racconti, le idee e la biografia">';
    } ?>
    <link rel="icon" type="image/x-icon" href="<?= get_site_url(); ?>/wp-content/uploads/marco-valeri-net-logo-small.jpg">

    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="4b120a0a-4508-4f16-ac83-f0ecefe1e60b" data-blockingmode="auto" type="text/javascript"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y5V630M9K0"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-Y5V630M9K0');
    </script>
    <?php wp_head(); ?>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar__toggle">
                <label for="navbar menu" aria-label="navbar menu"></label>
                <input id="navbar menu" name="navbar menu" class="navbar__input" type="checkbox" aria-label="navbar menu" />
                <span class="navbar__span"></span>
                <span class="navbar__span"></span>
                <span class="navbar__span"></span>
                <ul class="navbar__menu">
                    <li class="navbar__element navbar__logo">
                        <a class="brand-name no-link" href="<?= get_site_url(); ?>">Marco Valeri</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>">Home</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/chi-sono/") ? 'navbar__element--mark' : '' ?>" >
                        <a class="navbar__link" href="<?= get_site_url(); ?>/chi-sono/">Chi sono</a>
                    </li>
                    <li class="navbar__element  <?= isThisUrlPath("/category/esperienze/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/esperienze/">Esperienze</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/category/opportunita/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/opportunita/">Opportunità</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/category/vivere-estero/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/vivere-estero/">Vivere All'Estero</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/contatti/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/contatti/">Contatti</a>
                    </li>
                    <li class="navbar__element <?= isThisUrlPath("/newsletter/") ? 'navbar__element--mark' : '' ?>">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/newsletter/">Newsletter</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="header__hero">
            <div class="header__container">
                <h1 class="header__title font-tangerine">Marco Valeri</h1>
            </div>
        </div>
    </header>
    <main class="main">