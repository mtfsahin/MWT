<?php
// tests/VisibleTokenStrategyTest.php

use MwtToken\Strategy\VisibleTokenStrategy;
use PHPUnit\Framework\TestCase;

class VisibleTokenStrategyTest extends TestCase {
    public function testTokenGeneration() {
        $strategy = new VisibleTokenStrategy();
        $token = $strategy->generateToken(['userid' => 123]);

        $this->assertNotEmpty($token, "Token should not be empty");
        $decodedData = json_decode(base64_decode($token), true);
        $this->assertEquals(123, $decodedData['userid'], "Decoded token should contain the correct user ID");
    }
}