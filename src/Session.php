<?php

namespace Shadowhand\RadioTide;

class Session
{
    /**
     * @param string $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return !empty($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function del($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @param string $group
     * @param array $values
     *
     * @return array
     */
    public function merge($group, array $values)
    {
        $current = $this->get($group, []);
        $values  = array_replace_recursive($current, $values);
        return $_SESSION[$group] = $values;
    }
}
