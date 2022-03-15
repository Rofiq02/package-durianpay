<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Order;

class Metadata
{
    /**
     * Item basket.
     *
     * @var array
     */
    private $items = [];

    /**
     * Set an item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value)
    {
        $this->items[$key] = $value;
        return $this;
    }

    /**
     * Get an item.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return isset($this->items[$key]) ? $this->items[$key] : $default;
    }

    /**
     * Remove an item.
     *
     * @param string $key
     */
    public function forget(string $key)
    {
        unset($this->items[$key]);
    }

    /**
     * Fetch all items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Check if item is empty.
     *
     * @return bool
     */
    public function empty()
    {
        return count($this->items) <= 0;
    }

    /**
     * Reset item basket.
     *
     * @return self
     */
    public function reset()
    {
        $this->items = [];

        return $this;
    }
}
