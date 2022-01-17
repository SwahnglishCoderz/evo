<?php

namespace App;

use Exception;

/**
 * Unique random tokens
 *
 * PHP version 7.0
 */
class Token
{

    /**
     * The token value
     */
    protected $token;

    /**
     * Class constructor. Create a new random token or assign an existing one if passed in.
     * @throws Exception
     */
    public function __construct($token_value = null)
    {
        if ($token_value) {

            $this->token = $token_value;

        } else {
        
            $this->token = bin2hex(random_bytes(16));  // 16 bytes = 128 bits = 32 hex characters
        }
    }

    /**
     * Get the token value
     */
    public function getValue()
    {
        return $this->token;
    }

    /**
     * Get the hashed token value
     */
    public function getHash(): string
    {
        return hash_hmac('sha256', $this->token, Config::HASHING_SECRET_KEY);  // sha256 = 64 chars
    }
}
