<?php

namespace App\Controller\Web;

use App\Entity\Checkout;
use App\Entity\Payment;
use App\Entity\Product;
use App\Repository\CheckoutRepository;
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
     * @var CartService
     */
    private $cartService;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(CartService $cartService, SessionInterface $session)
    {
        $this->cartService = $cartService;
        $this->session = $session;
    }

    /**
     * @Route("/web/cart", name="web_cart")
     */
    public function index()
    {

        $calculation = $this->cartService->getCartCalculation();

        return $this->render('web/cart/index.html.twig', [
            'inventory' => $calculation,
        ]);
    }

    /**
     * @Route("/web/cart/remove/{id}", name="web_cart_remove", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function removeAction(Product $product)
    {
        $this->cartService->removeProduct($product);

        return $this->redirectToRoute('web_cart');
    }

    /**
     * @Route("/web/cart/reduce/{id}/{qty}", name="web_cart_reduce", requirements={"id"="\d+","qty"="\d+"}, methods={"POST"})
     */
    public function reduceAction(Product $product, $qty = 1)
    {

        $this->cartService->addProduct($product, $qty * -1);

        return $this->redirectToRoute('web_cart');
    }

    /**
     * @Route("/web/cart/add/{id}/{qty}", name="web_cart_add", requirements={"id"="\d+","qty"="\d+"}, methods={"POST"})
     */
    public function addAction(Product $product, $qty = 1, Request $request)
    {

        $this->cartService->addProduct($product, $qty);

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
    public function purgeAction() {

        $this->cartService->purgeCartInventory();

        return $this->redirectToRoute('web_cart');
    }

    /**
     * @Route("/web/cart/checkout", name="web_cart_checkout", methods={"POST"})
     */
    public function checkout(Request $request, Payum $payum)
    {

        $gateway = $request->request->get('gateway');

        // make sure buyer has supplied his contact email address.
        $email = filter_var($request->request->get('buyersEmail'), FILTER_VALIDATE_EMAIL);
        if (false === $email) {
            $this->addFlash('webCartModalError', 'Please supply your email address. So we can contact you.');
            return $this->redirectToRoute('web_cart');
        }

        switch ( $gateway ) {
            case 'paypal_express_checkout':
                return $this->checkoutWithPaypalExpressCheckout($payum, $email);
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

        // if the payment was 'captured' then the transaction has been completed.
        // hence empty the cart.
        if ('captured' === $status->getValue()) {
            $this->cartService->purgeCartInventory();
            $this->session->invalidate();
            $this->addFlash('success', 'Thank you for your purchase, we will be in touch with you soon.');
        }

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

    private function checkoutWithPaypalExpressCheckout(Payum $payum, $buyerEmail)
    {

        $gatewayName = 'paypal_express_checkout';

        $storage = $payum->getStorage('App\Entity\Payment');

        $payment = $storage->create();
        $payment->setNumber($this->session->getId());
        $payment->setCurrencyCode('USD');
        $payment->setTotalAmount($this->cartService->getPayumTotalCost()); // 1.23
        $payment->setDescription($this->cartService->describeCart());
        $payment->setClientId($buyerEmail);
        $payment->setClientEmail($buyerEmail);

        $storage->update($payment);

        $captureToken = $payum->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $payment,
            'web_cart_done' // the route to redirect after capture
        );

        return $this->redirect($captureToken->getTargetUrl());
    }

}
