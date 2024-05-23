<?php

namespace App\Services;

use phpseclib3\Crypt\PublicKeyLoader;

class RSAEncryption {
    private string $publicKey;

    public function __construct() {
        $this->publicKey = env("OLA_PUB_KEY");
    }

    public function encrypt($data) {
        $rsa = PublicKeyLoader::load($this->publicKey);
        return base64_encode($rsa->encrypt($data));
    }
}
