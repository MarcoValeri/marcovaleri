<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marco Valeri</title>
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
                        <a class="brand-name no-link" href="/">Marco Valeri</a>
                    </li>
                    <li class="navbar__element navbar__element--mark">
                        <a class="navbar__link" href="<?= get_site_url(); ?>">Home</a>
                    </li>
                    <li class="navbar__element" >
                        <a class="navbar__link" href="<?= get_site_url(); ?>/chi-sono">Chi sono</a>
                    </li>
                    <li class="navbar__element">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/esperienze">Esperienze</a>
                    </li>
                    <li class="navbar__element">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/opportunita">Opportunità</a>
                    </li>
                    <li class="navbar__element">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/vivere-estero">Vivere All'Estero</a>
                    </li>
                    <li class="navbar__element">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/contatti">Contatti</a>
                    </li>
                    <li class="navbar__element">
                        <a class="navbar__link" href="<?= get_site_url(); ?>/category/newsletter">Newsletter</a>
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