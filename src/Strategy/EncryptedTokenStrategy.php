<?php
// src/Strategy/EncryptedTokenStrategy.php

namespace MwtToken\Strategy;

class EncryptedTokenStrategy implements TokenStrategy {
    private $secretKey;

    public function __construct(string $secretKey) {
        $this->secretKey = $secretKey;
    }

    public function generateToken(array $data): string {
        $payload = json_encode($data);
        $encryptedData = openssl_encrypt($payload, 'AES-128-ECB', $this->secretKey);
        return base64_encode($encryptedData);
    }
}
