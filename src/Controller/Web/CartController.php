<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/web/cart", name="web_cart")
     */
    public function index()
    {
        return $this->render('web/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
