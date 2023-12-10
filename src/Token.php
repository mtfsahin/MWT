<?php
class Token {
    private $payload;
    private $expiryDate;

    public function __construct($payload, $expiryDate) {
        $this->payload = $payload;
        $this->setExpiryDate($expiryDate);
    }

    public function getPayload() {
        return $this->payload;
    }

    private function setExpiryDate(string $expiryDate) {
        try {
            $this->expiryDate = new DateTime($expiryDate);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Invalid expiry date format.");
        }
    }

    public function isExpired() {
        $currentDateTime = new DateTime();
        return $currentDateTime >= $this->expiryDate;
    }
}