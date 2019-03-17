<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/web", name="web_index")
     */
    public function index()
    {
        return $this->render('web/default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
