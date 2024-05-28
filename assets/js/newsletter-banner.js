window.onload = () => {

    // DOM variables
    const newsletterBannerButton = document.getElementById('newsletter-banner-button');
    const newsletterBannerContent = document.getElementById('newsletter-banner-content');
    const newsletterBannerForm = document.getElementById('newsletter-banner-form');

    // Click event that shows the newsletter form
    if (newsletterBannerButton) {
        newsletterBannerButton.addEventListener('click', () => {

            if (newsletterBannerContent) {
                newsletterBannerContent.style.display = "none";
            }

            if (newsletterBannerForm) {
                newsletterBannerForm.style.display = "block";
            }

        })
    }
}