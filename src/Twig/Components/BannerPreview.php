<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class BannerPreview
{
    public string $bannerPreviewImage;
    public string $bannerPreviewImageAlt;
    public string $bannerPreviewTitle;
    public string $bannerPreviewDescription;
    public string $bannerPreviewLink;
    public string $bannerPreviewButton;
}