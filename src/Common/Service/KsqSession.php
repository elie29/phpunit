<?php

namespace Common\Service;

class KsqSession
{

    /**
     * Session destroy indicator.
     * @var boolean
     */
    private $destroy = false;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @param int $lifetime Lifetime in seconds. 25-minute default value.
     */
    public function __construct(int $lifetime = 1500)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * Verify if $key exist in the session.
     *
     * @param string $key key name.
     *
     * @return boolean
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Set a key in the session.
     *
     * @param string $key key name.
     * @param mixed $value value to be stored.
     *
     * @return \Common\Service\KsqSession
     */
    public function set($key, $value)
    {
        // Serialize value
        $_SESSION[$key] = serialize($value);
        // Keep chaining
        return $this;
    }

    /**
     * Get a key from the session.
     *
     * @param string $key key name.
     * @param mixed $default Default value to be returned when $key does not exist.
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            // Try to unserialize
            $default = @unserialize($_SESSION[$key]);
        }
        return $default;
    }

    /**
     * Indicate that a user has logged in.
     *
     * @return \Common\Service\KsqSession
     */
    public function login()
    {
        $this->set('session.__USER_CONNECT__', true);
        return $this;
    }

    /**
     * Whether a user is logged in or not.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->get('session.__USER_CONNECT__', false);
    }

    /**
     * Postpone session destroy.
     *
     * @return \Common\Service\KsqSession
     */
    public function prepareForDestroy()
    {
        $this->destroy = true;
        return $this;
    }

    /**
     * Destroy the postponed session.
     *
     * @return boolean
     */
    public function destroyIfNeeded()
    {
        if ($this->destroy) {
            return $this->destroy();
        }
        return false;
    }

    /**
     * @codeCoverageIgnore
     * @throws KsqException
     *
     * @return \Common\Service\KsqSession
     */
    public function start()
    {
        $this->createSID();

        if (!session_start()) {
            throw new KsqException('An error has occured while creating the session.');
        }

        return $this->updateTimer();
    }

    /**
     * Clear session hack.
     *
     * @return boolean true for testing purpose.
     */
    public function clear()
    {
        @session_unset();
        $_SESSION = array();

        return true;
    }

    /**
     * Destroy and delete the session.
     *
     * @return boolean true for testing purpose.
     */
    public function destroy()
    {
        $this->clear();
        @session_destroy();

        return true;
    }

    /**
     * @codeCoverageIgnore
     * Create a unique SID based on ASSOCIATEOID and ORGOID.
     */
    protected function createSID()
    {
        $sid = null;
        if (!DEV_MODE) {
            $data = $_SERVER['ASSOCIATEOID'] . $_SERVER['ORGOID'] . '__session__';
            $sid = hash('sha256', $data, false);
        }
        session_id($sid);
    }

    /**
     * @codeCoverageIgnore
     * Update timer and unset session after $lifetime of inactivity.
     *
     * @return \Common\Service\KsqSession
     */
    protected function updateTimer()
    {
        $now = time();
        $last = (int) $this->get('session.__LAST_ACTIVITY_TIME__', 0);

        // Activity lifetime expired?
        if ($last && $now > $last + $this->lifetime) {
            $this->clear();
            $this->set('session.__LAST_REINITIALIZED_TIME__', $now);
        }
        return $this->set('session.__LAST_ACTIVITY_TIME__', $now);
    }

    /** No clone nor serialize */
    final private function __clone() {}
    final private function __sleep() {}
}
