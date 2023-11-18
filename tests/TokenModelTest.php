<?php
// tests/TokenModelTest.php

use PHPUnit\Framework\TestCase;
use MwtToken\TokenModel;
use MwtToken\Strategy\VisibleTokenStrategy;

class TokenModelTest extends TestCase {
    public function testTokenGenerationAndValidation() {
        $strategy = new VisibleTokenStrategy();
        $tokenModel = new TokenModel($strategy);

        $data = ['userid' => 123];
        $token = $tokenModel->generateToken($data);

        $this->assertNotEmpty($token, "Token should not be empty");

        $isValid = $tokenModel->validateToken($token);
        $this->assertTrue($isValid, "Token should be valid");
    }
}
