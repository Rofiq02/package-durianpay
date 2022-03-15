<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Order;

class Items
{
    /**
     * Item basket.
     *
     * @var array
     */
    private $items = [];

    /**
     * Add an item.
     *
     * @param string $name
     * @param int    $qty
     * @param int    $price
     * @param string $logoUrl
     */
    public function add(string $name, int $qty, int $price, string $logoUrl)
    {
        $this->items[] = [
            'name' => $name,
            'qty' => $qty,
            'price' => $price . '.00',
            'logo' => $logoUrl,
        ];

        return $this;
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
