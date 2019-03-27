<?php

namespace App\Controller\Web;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private $session;
    const CART_SESSION_NAME = 'app_cart_items';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/web/product/{slug}", name="web_product")
     */
    public function show(Product $product)
    {
        $alreadyInCart = $this->extractIDsFromCart();

        return $this->render('web/product/show.html.twig', [
            'product' => $product,
            'alreadyInCart' => $alreadyInCart,
        ]);
    }

    /**
     * @return array
     */
    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private function extractIDsFromCart()
    {
        $productIds = [];
        foreach ($this->getCartItems() as $item) {
            $productIds[] = $item['productId'];
        }

        return $productIds;
    }

    /**
     * @return array
     */
    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private function getCartItems()
    {
        return $this->session->get(self::CART_SESSION_NAME, []);
    }
}
