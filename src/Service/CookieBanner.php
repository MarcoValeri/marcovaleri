<?php

namespace App\Service;

class CookieBanner {

    private $message = "Questo sito utilizza i cookie o tecnologie simili";

    public function getMessage() {
        return $this->message;
    }

}