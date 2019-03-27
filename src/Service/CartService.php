<?php
/**
 * Created by PhpStorm.
 * User: arvil
 * Date: 2019-03-27
 * Time: 11:21.
 */

namespace App\Service;

use App\Entity\Product;
use App\Helper\CartInventory;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    const CART_SESSION_NAME = 'app_cart_inventory';

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository, SessionInterface $session)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function addProduct(Product $product, int $qty = 1)
    {
        $inventory = $this->getCartInventory();

        $inventory->addProduct($product, $qty);

        $this->setCartInventory($inventory);

        return $this;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $newInventory = $this->getCartInventory()->removeProduct($product);

        $this->setCartInventory($newInventory);

        return $this;
    }

    public function describeCart()
    {
        $items = $this->getCartInventory()->getItems();

        $itemsCount = count($items);

        $string = '';

        for ($i = 0; $i < $itemsCount; ++$i) {
            $product = $this->productRepository->find($items[$i][$this->getCartInventory()::PRODUCT_ID_ARRAY_KEY]);
            $string .= $items[$i]['qty'].' x '.$product->getName().'; ';
        }

        return trim($string, ' ;');
    }

    /**
     * @return int
     */
    public function getPayumTotalCost()
    {
        return (int) ($this->getCartCalculation()['totalCost'] * 100);
    }

    /**
     * @return array
     */
    public function getCartCalculation()
    {
        $calculation = [
            'totalCost' => '0', // Magic.
            'products' => [],
        ];

        /**
         * TODO: Implement this by getting the Products on a single SQL query.
         *
         *   $productIds = $this->getCartInventory()->getProductIds();
         *   $products = $this->productRepository->findById($productIds);
         */
        $items = $this->getCartInventory()->getItems();
        $itemsCount = count($items);

        for ($i = 0; $i < $itemsCount; ++$i) {
            $product = $this->productRepository->find($items[$i][$this->getCartInventory()::PRODUCT_ID_ARRAY_KEY]);
            $calculation['products'][$i]['product'] = $product;
            $calculation['products'][$i]['qty'] = $items[$i]['qty'];
            $calculation['products'][$i]['total'] = floatval($product->getPrice()) * $items[$i]['qty'];
            $calculation['totalCost'] += $calculation['products'][$i]['total'];
        }

        return $calculation;
    }

    /**
     * @return array
     */
    public function getProductIds()
    {
        return $this->getCartInventory()->getProductIds();
    }

    /**
     * @return CartInventory
     */
    public function getCartInventory()
    {
        return $this->session->get(self::CART_SESSION_NAME, new CartInventory());
    }

    /**
     * @return CartInventory
     */
    public function purgeCartInventory()
    {
        $this->session->set(self::CART_SESSION_NAME, new CartInventory());
    }

    /**
     * @param CartInventory $cartInventory
     *
     * @return $this
     */
    private function setCartInventory(CartInventory $cartInventory)
    {
        $this->session->set(self::CART_SESSION_NAME, $cartInventory);

        return $this;
    }
}
