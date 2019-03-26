<?php

namespace App\Controller\Web;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private $session;
    const CART_SESSION_NAME = 'app_cart_items';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/web", name="web_home")
     */
    public function index(ProductRepository $productRepository)
    {

        $products = $productRepository->findAll();

        $alreadyInCart = $this->extractIDsFromCart();

        return $this->render('web/default/home.html.twig', [
            'products' => $products,
            'alreadyInCart' => $alreadyInCart,
        ]);
    }

    /**
     * @return array
     */
    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private function extractIDsFromCart()
    {
        $productIds = array();
        foreach ($this->getCartItems() as $item) {
            $productIds[] = $item['productId'];
        }
        return $productIds;
    }

    /**
     * @return array
     */
    // TODO: Move cart item manipulation to a service that can be injected to different routes.
    private function getCartItems() {
        return $this->session->get(self::CART_SESSION_NAME, array());
    }
}
