<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/web/cart/checkout", name="web_cart_checkout", methods={"POST"})
     */
    public function checkout(Request $request) {
        dd($request->request->all());
    }
}
