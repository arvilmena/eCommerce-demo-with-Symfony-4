<?php

namespace App\Controller\Web;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="web_admin")
     */
    public function index(PaymentRepository $paymentRepository)
    {
        $payments = $paymentRepository->findProcessed();

        return $this->render('web/admin/index.html.twig', [
            'payments' => $payments,
        ]);
    }
}
