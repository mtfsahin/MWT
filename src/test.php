<?php

require_once 'Token.php';
require_once 'TokenFactory.php';
require_once 'TokenManager.php';
require_once 'Strategy/EncodingStrategyInterface.php';
require_once 'Strategy/PlainEncodingStrategy.php';
require_once 'Strategy/EncryptedEncodingStrategy.php';

// EncryptedEncodingStrategy usage
$secretKey = 'your-very-secure-secret-key';
$enhancedStrategy = new EncryptedEncodingStrategy($secretKey);

$payload = ['data' => 'This is a test'];
$encoded = $enhancedStrategy->encode($payload);

$decoded = $enhancedStrategy->decode($encoded);
echo 'Encoded: ' . $encoded . '\n';
echo 'Decoded: ';
print_r($decoded);

// PlainEncodingStrategy usage
$plainStrategy = new PlainEncodingStrategy();

$plainEncoded = $plainStrategy->encode($payload);

$plainDecoded = $plainStrategy->decode($plainEncoded);
echo '\nPlain Encoded: ' . $plainEncoded . '\n';
echo 'Plain Decoded: ';
print_r($plainDecoded);