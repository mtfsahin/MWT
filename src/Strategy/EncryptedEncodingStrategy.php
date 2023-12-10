<?php

class EncryptedEncodingStrategy implements EncodingStrategyInterface {
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function encode($payload, $additionalHeaders = []) {
        $header = json_encode(array_merge(['alg' => 'HS256', 'typ' => 'JWT'], $additionalHeaders));
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha512', $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function decode($jwt) {
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $jwt);
        $data = $base64UrlHeader . '.' . $base64UrlPayload;

        $signature = $this->base64UrlDecode($base64UrlSignature);
        $expectedSignature = hash_hmac('sha512', $data, $this->secretKey, true);

        if (!hash_equals($expectedSignature, $signature)) {
            throw new Exception('Invalid token signature');
        }

        return json_decode($this->base64UrlDecode($base64UrlPayload), true);
    }

    private function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
