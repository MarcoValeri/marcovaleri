<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class BannerAuthor
{
    public string $bannerAuthorImage;
    public string $bannerAuthorImageAlt;
    public string $bannerAuthorTitle;
    public string $bannerAuthorDescription;
}