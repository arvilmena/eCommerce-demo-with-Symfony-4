<?php

namespace App\Controller\Web;

use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
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
    public function checkout(Request $request, Payum $payum)
    {

        $gateway = $request->request->get('gateway');

        switch ( $gateway ) {
            case 'paypal_express_checkout':
                return $this->checkoutWithPaypalExpressCheckout($payum);
                break;
        }
    }

    /**
     * @Route("/web/cart/checkout/done", name="web_cart_done")
     */
    public function doneAction(Request $request, Payum $payum)
    {
        $token = $payum->getHttpRequestVerifier()->verify($request);

        $token = $payum->getHttpRequestVerifier()->verify($request);

        $gateway = $payum->getGateway($token->getGatewayName());

        // You can invalidate the token, so that the URL cannot be requested any more:
        // $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        // Once you have the token, you can get the payment entity from the storage directly.
        // $identity = $token->getDetails();
        // $payment = $this->get('payum')->getStorage($identity->getClass())->find($identity);

        // Or Payum can fetch the entity for you while executing a request (preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        // Now you have order and payment status

        return $this->json(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
    }

    private function checkoutWithPaypalExpressCheckout(Payum $payum)
    {

        $gatewayName = 'paypal_express_checkout';

        $storage = $payum->getStorage('App\Entity\Payment');

        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('USD');
        $payment->setTotalAmount(123); // 1.23 EUR
        $payment->setDescription('Buying stuffs');
        $payment->setClientId('anId');
        $payment->setClientEmail('arvilmena@gmail.com');

        $storage->update($payment);

        $captureToken = $payum->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $payment,
            'web_cart_done' // the route to redirect after capture
        );

        return $this->redirect($captureToken->getTargetUrl());
    }

}
