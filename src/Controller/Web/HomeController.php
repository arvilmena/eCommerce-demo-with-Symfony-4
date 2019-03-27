<?php

namespace App\Controller\Web;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/web", name="web_home")
     */
    public function index(ProductRepository $productRepository, CartService $cartService)
    {
        $products = $productRepository->findAll();

        $alreadyInCart = $cartService->getProductIds();

        return $this->render('web/default/home.html.twig', [
            'products' => $products,
            'alreadyInCart' => $alreadyInCart,
        ]);
    }
}
