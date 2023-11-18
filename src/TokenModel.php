<?php
// src/TokenModel.php

namespace MwtToken;

use MwtToken\Strategy\TokenStrategy;

class TokenModel {
    private $strategy;
    private $secretKey;

    public function __construct(TokenStrategy $strategy) {
        $this->strategy = $strategy;
        $this->secretKey = $this->generateSecureKey();
    }

    private function generateSecureKey() {
        return bin2hex(random_bytes(32));
    }

    public function generateToken(array $data): string {
        $header = base64_encode(json_encode([
            'typ' => 'MWT',
            'alg' => 'HS256',
            'exp' => time() + 3600,
            'jti' => bin2hex(random_bytes(16))
        ]));

        $payload = $this->strategy->generateToken($data);
        $signature = hash_hmac('sha256', $header . "." . $payload, $this->secretKey, true);

        return $header . "." . $payload . "." . base64_encode($signature);
    }

    public function validateToken(string $token): bool {
        try {
            [$header, $payload, $signature] = explode('.', $token);
            $expectedSignature = hash_hmac('sha256', $header . "." . $payload, $this->secretKey, true);
            return hash_equals(base64_decode($signature, true), $expectedSignature);
        } catch (\Exception $e) {
            return false;
        }
    }
}
