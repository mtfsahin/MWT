<?php

namespace MwtToken\Strategy;

/**
 * A class to make tokens with secret coding.
 * It uses AES-128-ECB to code the data.
 */
class EncryptedTokenStrategy implements TokenStrategy {
    /**
     * The secret key for coding the data.
     * @author mtfsahin
     * @var string
     */
    private $secretKey;

    /**
     * Constructor for EncryptedTokenStrategy.
     * @author mtfsahin
     * @param string $secretKey The secret key for the coding.
     */
    public function __construct(string $secretKey) {
        $this->secretKey = $secretKey;
    }

    /**
     * Makes a coded token from data.
     * @author mtfsahin
     * @param array $data The data to put in the token.
     * @return string The token, coded and changed to base64.
     */
    public function generateToken(array $data): string {
        $payload = json_encode($data);
        $encryptedData = openssl_encrypt($payload, 'AES-128-ECB', $this->secretKey);
        return base64_encode($encryptedData);
    }
}
