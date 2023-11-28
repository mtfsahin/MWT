<?php

interface EncodingStrategyInterface {
    public function encode($payload);
    public function decode($token);
}
