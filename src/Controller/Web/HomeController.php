<?php

namespace App\Controller\Web;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/web", name="web_home")
     */
    public function index(ProductRepository $productRepository)
    {

        $products = $productRepository->findAll();

        return $this->render('web/default/home.html.twig', [
            'products' => $products,
        ]);
    }
}
