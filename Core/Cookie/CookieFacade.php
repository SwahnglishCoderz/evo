<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\Cookie;

use Evo\Cookie\Store\NativeCookieStore;

class CookieFacade
{
    protected string $store;
    protected Object $cookieEnvironment;

    /**
     * Main cookie facade class which pipes the properties to the method arguments. 
     * Which also defines the default cookie store.
     */
    public function __construct(?array $cookieEnvironmentArray = null, ?string $store = null)
    {
        $cookieArray = array_merge((new CookieConfig())->baseConfig(), $cookieEnvironmentArray);
        $this->cookieEnvironment = new CookieEnvironment($cookieArray);
        $this->store = ($store != null) ? $store : NativeCookieStore::class;
    }

    /**
     * Create an instance of the cookie factory and inject all the required
     * dependencies i.e. the cookie store object and the cookie environment
     * configuration.
     */
    public function initialize(): Object
    {
        return (new CookieFactory())->create($this->store, $this->cookieEnvironment);
    }
}
