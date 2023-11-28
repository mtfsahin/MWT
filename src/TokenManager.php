<?php

require_once 'Token.php';

class TokenManager {
    private $tokens = [];
    private $strategy;

    public function __construct(EncodingStrategyInterface $strategy) {
        $this->strategy = $strategy;
    }

    public function addToken(Token $token) {
        $this->tokens[] = $token;
    }

    public function encodeToken($payload) {
        return $this->strategy->encode($payload);
    }

    public function decodeToken($mwt) {
        return $this->strategy->decode($mwt);
    }

    public function validateToken($mwt) {
        $decodedPayload = $this->strategy->decode($mwt);
        foreach ($this->tokens as $token) {
            if ($token->getPayload() == $decodedPayload && !$token->isExpired()) {
                return true;
            }
        }
        return false;
    }

    public function getTokens() {
        return $this->tokens;
    }
}
