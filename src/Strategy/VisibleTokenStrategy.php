<?php
namespace MwtToken\Strategy;
/**
 * A class to make tokens that you can see.
 * This class changes the data to a special text format.
 */
class VisibleTokenStrategy implements TokenStrategy {
    /**
     * Makes a token that shows the data in a special text format (base64).
     * @author mtfsahin
     * @param array $data The data to turn into a token.
     * @return string The token made from the data.
     */
    public function generateToken(array $data): string {
        return base64_encode(json_encode($data));
    }
}
