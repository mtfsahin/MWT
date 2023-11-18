<?php
// tests/Strategy/EncryptedTokenStrategyTest.php

use PHPUnit\Framework\TestCase;
use MwtToken\Strategy\EncryptedTokenStrategy;

class EncryptedTokenStrategyTest extends TestCase {
    private $secretKey;

    protected function setUp(): void {
        $this->secretKey = 'yourSecretKey';
    }

    public function testGenerateToken() {
        $strategy = new EncryptedTokenStrategy($this->secretKey);
        $data = ['userid' => 123];
        $token = $strategy->generateToken($data);

        $this->assertNotEmpty($token, "Token should not be empty");

        $decryptedData = openssl_decrypt(base64_decode($token), 'AES-128-ECB', $this->secretKey);
        $decodedData = json_decode($decryptedData, true);

        $this->assertEquals($data, $decodedData, "Decoded token data should match the original data");
    }
}
