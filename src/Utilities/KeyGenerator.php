<?php

class SecretKeyGenerator {
    private $logFilePath;

    public function __construct() {
        $this->logFilePath = ini_get('error_log');

        if (!$this->logFilePath) {
            $this->logFilePath = __DIR__ . '/secret_key_generator.log';
        }
    }

    private function findEnvFile($currentDir) {
        $envFilePath = $currentDir . '/.env';
        if (file_exists($envFilePath)) {
            return $envFilePath;
        }

        $parentDir = dirname($currentDir);
        if ($parentDir == $currentDir) {
            return null;
        }

        return $this->findEnvFile($parentDir);
    }

    private function generateSecretKey() {
        return bin2hex(random_bytes(32)); // 32 bytes = 256 bit key
    }

    private function keyExistsInEnv($envFilePath) {
        $envContent = file_get_contents($envFilePath);
        return strpos($envContent, 'SECRET_KEY=') !== false;
    }

    private function writeKeyToEnv($envFilePath, $key) {
        file_put_contents($envFilePath, "SECRET_KEY=$key\n", FILE_APPEND);
    }

    private function logMessage($message) {
        file_put_contents($this->logFilePath, date('Y-m-d H:i:s') . ' - ' . $message . "\n", FILE_APPEND);
    }

    public function generateAndSaveKey() {
        $currentDir = __DIR__;
        $envFilePath = $this->findEnvFile($currentDir);

        if (!$envFilePath) {
            $this->logMessage('No .env file found.');
            return;
        }

        if ($this->keyExistsInEnv($envFilePath)) {
            $this->logMessage('Secret key already exists in .env file.');
            return;
        }

        $key = $this->generateSecretKey();
        $this->writeKeyToEnv($envFilePath, $key);
        $this->logMessage('Secret key generated and saved to .env file.');
    }
}
