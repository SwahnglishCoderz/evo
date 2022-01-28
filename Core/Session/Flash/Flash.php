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

namespace Evo\Session\Flash;

use Evo\Session\SessionTrait;
use Evo\Session\SessionInterface;

class Flash implements FlashInterface
{
    use SessionTrait;

    protected const FLASH_KEY = 'flash_message';
    protected string $flashKey;
    protected ?SessionInterface $session;

    /**
     * Class constructor method which accepts a single default argument
     * which allows the user to specify their own flash key as an option
     * else if not present will use the default set by the framework
     */
    public function __construct(?Object $session = null, ?string $flashKey = null)
    {
        $this->session = $session;
        if ($flashKey !=null) {
            $this->flashKey = $flashKey;
        } else {
            $this->flashKey = self::FLASH_KEY;
        }
    }

    public function getSessionObject(object $session): self
    {
        $this->session = $session;
        return $this;
    }

    public function add(string $message, ?string $type = null) : void
    {
        /* Apply default constants to flash type */
        if ($type === null) {
            $type = FlashType::SUCCESS;
        }
        if ($this->session->has($this->flashKey)) {
            $this->session->set($this->flashKey, []);
        }
        $this->session->setArray($this->flashKey,
            [
                'message' => $message,
                'type' => $type
            ]
        );
    }

    public function get()
    {
        if ($this->session->has($this->flashKey)) {
            return $this->session->flush($this->flashKey);
        }
    }

}