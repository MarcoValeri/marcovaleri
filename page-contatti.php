<?php get_header(); ?>
<form>
    <div class="contact-grid">
        <div class="contact-grid__title">
            <h2 class="contact-grid__title-main">Marco Valeri contatti</h2>
            <p class="contact-grid__title-sub">
                Sentiti libero di scrivermi tramite il seguente form per qualsiasi questione o esigenza
            </p>
        </div>
        <div class="contact-grid__name contact-grid__input">
            <label for="contact-name">Nome*</label>
            <input type="text" name="contact-name" />
        </div>
        <div class="contact-grid__surname contact-grid__input">
            <label for="contact-name">Cognome*</label>
            <input type="text" name="contact-surname" />
        </div>
        <div class="contact-grid__email contact-grid__input">
            <label for="contact-name">Email*</label>
            <input type="email" name="contact-email" />
        </div>
        <div class="contact-grid__message contact-grid__input">
            <label for="contact_message" class="required">Messaggio *</label><textarea id="contact_message" name="contact[message]" required="required"></textarea>
        </div>
        <div class="contact-grid__submit contact-grid__input">
            <button type="submit" id="contact_submit" name="contact[submit]">Invia</button>
        </div>
    </div>
</form>
<?php get_footer(); ?>