<?php

namespace MwtToken;

use MwtToken\Strategy\TokenStrategy;

/**
 * The main class to make and check tokens.
 * It uses different strategies to make tokens.
 */
class TokenModel {
    private $strategy;

    private $secretKey;

    public function __construct(TokenStrategy $strategy, string $secretKey = '') {
        $this->strategy = $strategy;
        $this->secretKey = $secretKey ?: $this->generateSecureKey();
    }
    /**
     * Makes a secure key for the token.
     * @author mtfsahin
     * @return string A secure key.
     */
    private function generateSecureKey() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Makes a token using the given data.
     * @author mtfsahin
     * @param array $data The data to put in the token.
     * @return string The created token.
     */
    public function generateToken(array $data): string {
        $header = base64_encode(json_encode([
            'typ' => 'MWT',
            'alg' => 'HS256',
            'exp' => time() + 3600,
            'jti' => bin2hex(random_bytes(16))
        ]));

        $payload = $this->strategy->generateToken($data);
        $signature = hash_hmac('sha256', $header . ".mtf_sahin." . $payload, $this->secretKey, true);

        return $header . ".mtf_sahin." . $payload . ".mtf_sahin." . base64_encode($signature);
    }

    /**
     * Checks if a token is valid.
     * @author mtfsahin
     * @param string $token The token to check.
     * @return bool True if the token is valid, false otherwise.
     */
    public function validateToken(string $token): bool {
        try {
            [$header, $payload, $signature] = explode('.mtf_sahin.', $token);
            $expectedSignature = hash_hmac('sha256', $header . ".mtf_sahin." . $payload, $this->secretKey, true);
            return hash_equals(base64_decode($signature, true), $expectedSignature);
        } catch (\Exception $e) {
            return false;
        }
    }
}
