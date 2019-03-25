<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/web/product/google-pixel-black", name="web_product")
     */
    public function show()
    {
        $product = array(
            'name' => 'Google Pixel - Black',
            'price' => '10',
            'image' => 'product-1.png',
            'description' => 'Spicy jalapeno bacon ipsum dolor amet kielbasa sausage ham hock jerky tenderloin, venison pork belly turducken. Tail landjaeger pork loin, kevin turkey shoulder andouille t-bone ground round tongue shankle pancetta ham boudin ham hock. Bacon cupim t-bone filet mignon shoulder, bresaola beef ribs capicola chuck. Tail jowl pancetta beef bresaola, tongue turducken cupim ham hock buffalo pork chop pork belly meatball short ribs.',
        );

        return $this->render('web/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
