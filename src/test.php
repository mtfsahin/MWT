<?php

require_once 'Token.php';
require_once 'TokenFactory.php';
require_once 'TokenManager.php';
require_once 'Strategy/EncodingStrategyInterface.php';
require_once 'Strategy/PlainEncodingStrategy.php';
require_once 'Strategy/EncryptedEncodingStrategy.php';

$encryptedStrategy = new EncryptedEncodingStrategy("34sdg234");
$managerEncrypted = new TokenManager($encryptedStrategy);
$encryptedMWT = $managerEncrypted->encodeToken(['test' => 'encrypted']);
$decodedEncryptedPayload = $managerEncrypted->decodeToken($encryptedMWT);

echo "Encrypted MWT: " . $encryptedMWT . "\n";
print_r('</br>');
echo "Decoded Encrypted Payload: ";

print_r($decodedEncryptedPayload);
print_r('</br>');


$plainStrategy = new PlainEncodingStrategy();
$managerPlain = new TokenManager($plainStrategy);
$plainMWT = $managerPlain->encodeToken(['test' => 'plain']);
$decodedPlainPayload = $managerPlain->decodeToken($plainMWT);

echo "Plain MWT: " . $plainMWT . "\n";
print_r('</br>');
echo "Decoded Plain Payload: ";
print_r($decodedPlainPayload);
