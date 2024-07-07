<?php

require_once "../../vendor/autoload.php";

use PaymentLibrary\Core\Utils;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PayerInfo;
use PaymentLibrary\Factories\PaymentGatewayFactory;
use PaymentLibrary\Interfaces\PaymentGatewayFactoryInterface;

class PaymentProcessor {
    private $paymentGatewayFactory;
    private $config;

    public function __construct(PaymentGatewayFactoryInterface $paymentGatewayFactory, array $config) {
        $this->paymentGatewayFactory = $paymentGatewayFactory;
        $this->config = $config;
    }

    public function createPayPalPayment($amount, $currency, $description) {
        $apiContext = new ApiContext(
            new OAuthTokenCredential($this->config['client_id'], $this->config['client_secret'])
        );

        $payer = (new Payer())->setPaymentMethod('paypal');
        $redirectUrls = (new RedirectUrls())
            ->setReturnUrl("http://example.com/your_redirect_url_here")
            ->setCancelUrl("http://example.com/your_cancel_url_here");

        $payment = (new Payment())
            ->setIntent('authorize')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([[
                'amount' => ['currency' => $currency, 'total' => $amount],
                'description' => $description
            ]]);

        $payment->create($apiContext);

        header("Location: " . $payment->getApprovalLink());
        exit;
    }
}

$paymentGatewayFactory = new PaymentGatewayFactory();
$config = [
    'client_id' => Utils::env('PAYPAL_CLIENT_ID'),
    'client_secret' => Utils::env('PAYPAL_CLIENT_SECRET')
];

$paymentProcessor = new PaymentProcessor($paymentGatewayFactory, $config);

$paymentProcessor->createPayPalPayment(0.01, 'USD', 'Achat d\'un produit');