<?php
/**
 * Created by PhpStorm.
 * User: arvil
 * Date: 2019-03-27
 * Time: 11:21
 */

namespace App\Service;


use App\Entity\Product;
use App\Helper\CartInventory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    /**
     * @var SessionInterface
     */
    private $session;

    const CART_SESSION_NAME = 'app_cart_inventory';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
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

    public function getCartCalculation()
    {
        return $this->getCartInventory()->calculate();
    }

    /**
     * @return array
     */
    public function getProductIds() {
        return $this->getCartInventory()->getProductIds();
    }

    /**
     * @return CartInventory
     */
    public function getCartInventory()
    {
        return $this->session->get(self::CART_SESSION_NAME, new CartInventory($this->entityManager));
    }

    /**
     * @return CartInventory
     */
    public function purgeCartInventory()
    {
        $this->session->set(self::CART_SESSION_NAME, new CartInventory($this->entityManager));
    }

    /**
     * @param CartInventory $cartInventory
     * @return $this
     */
    private function setCartInventory(CartInventory $cartInventory)
    {
        $this->session->set(self::CART_SESSION_NAME, $cartInventory);

        return $this;
    }
}
