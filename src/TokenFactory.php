<?php

require_once 'Token.php';

class TokenFactory {
    private $strategy;

    public function __construct(EncodingStrategyInterface $strategy) {
        $this->strategy = $strategy;
    }

    public function createToken($payload, string $expiryDate = '+1 hour') {
        if (!$this->isValidPayload($payload)) {
            throw new InvalidArgumentException('Invalid payload.');
        }

        try {
            $token = new Token($payload, $expiryDate);
            return $this->strategy->encode($token->getPayload());
        } catch (Exception $e) {
            throw new Exception('Token creation failed: ' . $e->getMessage());
        }
    }

    private function isValidPayload($payload): bool {
        return true;
    }
}