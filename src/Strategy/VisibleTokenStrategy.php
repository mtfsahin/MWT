<?php
// src/Strategy/VisibleTokenStrategy.php

namespace MwtToken\Strategy;

class VisibleTokenStrategy implements TokenStrategy {
    public function generateToken(array $data): string {
        return base64_encode(json_encode($data));
    }
}
