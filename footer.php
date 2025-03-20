<?php get_sidebar(); ?>
</main>
<footer class="footer">
    <div class="footer__content">
        <p class="footer__content-main">Made with <span class="heart">&hearts;</span> in London by Marco Valeri - &copy; <?= date("Y"); ?> - All rights reserved</p>
        <p class="footer__content-main">
        <a class="no-link--white" href="<?= get_site_url(); ?>/privacy-policy">Privacy Policy</a>
        <span> - </span>
        <a class="no-link--white" href="<?= get_site_url(); ?>/cookie-policy">Cookie Policy</a>
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>