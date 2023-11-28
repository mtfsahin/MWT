<?php

class PlainEncodingStrategy implements EncodingStrategyInterface {
    public function encode($payload) {
        return base64_encode(json_encode($payload));
    }

    public function decode($token) {
        return json_decode(base64_decode($token), true);
    }
}