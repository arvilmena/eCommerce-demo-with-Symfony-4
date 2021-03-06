<?php
/**
 * Created by PhpStorm.
 * User: arvil
 * Date: 2019-03-27
 * Time: 11:38.
 */

namespace App\Helper;

use App\Entity\Product;

/**
 * Class CartInventory.
 */
class CartInventory
{
    const PRODUCT_ID_ARRAY_KEY = 'productId';

    /**
     * @var array
     */
    private $items = [];

    /**
     * @return array
     */
    public function getProductIds()
    {
        $ids = array_column($this->getItems(), self::PRODUCT_ID_ARRAY_KEY);

        return (is_array($ids)) ? $ids : [];
    }

    /**
     * @param Product $product
     * @param int     $qty
     *
     * @return $this
     */
    public function addProduct(Product $product, int $qty = 1)
    {
        $productId = $product->getId();

        // check if $productId is already in cart.
        $key = $this->getProductKey($productId);

        if (false !== $key) {
            $this->items[$key]['qty'] += $qty;
        } else {
            // create a new item in cart.
            $this->items[] = [
                self::PRODUCT_ID_ARRAY_KEY => $productId,
                'qty' => $qty,
            ];
        }

        // remove product if this operation causes the qty to go below 1.
        if (1 > $this->items[$key]['qty']) {
            $this->unsetInventoryKey($key);
        }

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return array $this->items
     */
    public function removeProduct(Product $product)
    {
        $productId = $product->getId();

        // check if $productId is indeed in cart.
        $key = $this->getProductKey($productId);

        if (false !== $key) {
            $this->unsetInventoryKey($key);
        }

        return $this;
    }

    /**
     * @param int $key
     *
     * @return array $this->items
     */
    private function unsetInventoryKey(int $key)
    {
        unset($this->items[$key]);
        // reset index.
        $this->items = array_values($this->items);

        return $this->items;
    }

    /**
     * @param int $productId
     *
     * @return false|int
     */
    private function getProductKey(int $productId)
    {
        return array_search($productId, array_column($this->items, self::PRODUCT_ID_ARRAY_KEY));
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
