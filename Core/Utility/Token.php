<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Evo\Utility;

use Evo\System\Config;
use Exception;

class Token
{

    /** @var string */
    protected string $token;

    /**
     * Class constructor. Create a new random token or assign an existing one if passed in.
     * @throws Exception
     */
    public function __construct(string $tokenValue = null, int $bytes = 16)
    {
        if ($tokenValue) {
            $this->token = $tokenValue;
        } else {
            $this->token = bin2hex(random_bytes($bytes));
        }
    }

    /**
     * Get the token value
     * 
     * @return string the token value
     * @throws Exception
     */
    public function getTokenValue() : string
    {
        return $this->token;
    }

    /**
     * Get the hashed token value The hashed value
     * @throws Exception
     */
    public function getHashedTokenValue() : string
    {
        // sha256 = 64 chars
//        return hash_hmac('sha256', $this->token, Yaml::file('app')['settings']['secret_key']);
        return hash_hmac('sha256', $this->token, Config::HASHING_SECRET_KEY);
    }

}