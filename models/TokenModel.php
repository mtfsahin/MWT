<?php
// models/TokenModel.php
class TokenModel {
    private $secretKey = '.V+O5VkFdWXE7PCtok7Fs37MtDumLgpEjuakJu81b2iI=';

    /**
     * Generate random uuidv4
     * @return string  UUID v4 value
     */
    private function generateUUIDv4() {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    /**
     * Generate MWT token with userID
     * @param int $userId UserId
     * @return string Generated Token, trie ==> isValid
     */
    public function generateToken($userId) {
        try {
            $header = base64_encode(json_encode(['typ' => 'MWT', 'alg' => 'HS256']));
            $payload = base64_encode(json_encode(['userid' => $userId]));
            $signature = hash_hmac('sha256', $header . ".mwt-type-mtf_sahin." . $payload, $this->secretKey, true);
            $signature = base64_encode($signature);
            setcookie("mwt_token", $header . ".mwt-type-mtf_sahin." . $payload . ".mwt-type-mtf_sahin." . $signature, time() + 3600, "/");
            return $header . ".mwt-type-mtf_sahin." . $payload . ".mwt-type-mtf_sahin." . $signature;
        } catch (Exception $e) {
            return "Token generated error: " . $e->getMessage();
        }
    }

    /**
     * Check Generated Token
     * @param string $token Token
     * @return bool IsValid Token
     */
    public function validateToken($token) {
        try {
            list($header, $payload, $signature) = explode(".mwt-type-mtf_sahin.", $token);
            $expectedSignature = base64_encode(hash_hmac('sha256', $header . ".mwt-type-mtf_sahin." . $payload, $this->secretKey, true));
            return $signature === $expectedSignature;
        } catch (Exception $e) {
            return "Token validating error: " . $e->getMessage();
        }
    }
}
?>
