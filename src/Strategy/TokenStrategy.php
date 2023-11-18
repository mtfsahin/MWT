<?php
// src/Strategy/TokenStrategy.php

namespace MwtToken\Strategy;

interface TokenStrategy {
    public function generateToken(array $data): string;
}
