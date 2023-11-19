<?php

namespace MwtToken\Strategy;

/**
 * An interface for making tokens.
 * This is a plan for how to make tokens.
 */

interface TokenStrategy {
    /**
     * Makes a token from data.
     * @author mtfsahin
     * @param array $data The data to make the token.
     * @return string The token made from the data.
     */
    public function generateToken(array $data): string;
}
