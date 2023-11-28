<?php


interface ObserverInterface {
    public function update(Token $token, $eventType);
}