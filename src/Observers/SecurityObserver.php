<?php

class SecurityObserver implements ObserverInterface {
    public function update(Token $token, $eventType) {
        if ($eventType === 'expired') {
            error_log("Security action for expired token: " . json_encode($token->getPayload()));
        }
    }
}