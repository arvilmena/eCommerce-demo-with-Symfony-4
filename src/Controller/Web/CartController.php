<?php

namespace App\Controller\Web;

use App\Entity\Payment;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route("/web/cart", name="web_cart")
     */
    public function index(CartService $cartService)
    {

        $calculation = $cartService->getCartCalculation();

        return $this->render('web/cart/index.html.twig', [
            'inventory' => $calculation,
        ]);
    }

    /**
     * @Route("/web/cart/remove/{id}", name="web_cart_remove", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function removeAction(Product $product, CartService $cartService)
    {
        $cartService->removeProduct($product);

        return $this->redirectToRoute('web_cart');
    }

    /**
     * @Route("/web/cart/reduce/{id}/{qty}", name="web_cart_reduce", requirements={"id"="\d+","qty"="\d+"}, methods={"POST"})
     */
    public function reduceAction(Product $product, $qty = 1, CartService $cartService)
    {

        $cartService->addProduct($product, $qty * -1);

        return $this->redirectToRoute('web_cart');
    }

    /**
     * @Route("/web/cart/add/{id}/{qty}", name="web_cart_add", requirements={"id"="\d+","qty"="\d+"}, methods={"POST"})
     */
    public function addAction(Product $product, $qty = 1, Request $request, CartService $cartService)
    {

        $cartService->addProduct($product, $qty);

        // if the returnTo field has value, return it to them.
        $pathName = $request->request->get('returnTo');
        if (null !== $pathName) {
            return $this->redirectToRoute($pathName);
        } else {
            return $this->redirectToRoute('web_cart');
        }
    }

    /**
     * @Route("/web/cart/clear", name="web_cart_clear")
     */
    public function purgeAction(CartService $cartService) {

        $cartService->purgeCartInventory();

        return $this->redirectToRoute('web_cart');
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
    public function doneAction(Request $request, Payum $payum, EntityManagerInterface $em)
    {

        $token = $payum->getHttpRequestVerifier()->verify($request);

        $gateway = $payum->getGateway($token->getGatewayName());

        // You can invalidate the token, so that the URL cannot be requested any more:
        $payum->getHttpRequestVerifier()->invalidate($token);

        // Once you have the token, you can get the payment entity from the storage directly.
        // $identity = $token->getDetails();
        // $payment = $this->get('payum')->getStorage($identity->getClass())->find($identity);

        // Or Payum can fetch the entity for you while executing a request (preferred).
        $gateway->execute($status = new GetHumanStatus($token));

        /* @var Payment $payment */
        $payment = $status->getFirstModel();

        // save payment gateway type and readable status to database.
        $payment->setPaymentGateway($token->getGatewayName());
        $payment->setReadableStatus($status->getValue());
        $em->persist($payment);
        $em->flush();

        // Now you have order and payment status
        $summary = array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        );

        return $this->redirectToRoute('web_cart', $request->query->all());
    }

    private function checkoutWithPaypalExpressCheckout(Payum $payum)
    {

        $gatewayName = 'paypal_express_checkout';

        $storage = $payum->getStorage('App\Entity\Payment');

        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('USD');
        $payment->setTotalAmount(123); // 1.23
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
