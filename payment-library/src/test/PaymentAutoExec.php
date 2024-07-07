
<?php

use PaymentLibrary\Core\Utils;
use PaymentLibrary\Factories\PaymentGatewayFactory;
use PaymentLibrary\Strategies\PaymentGatewayStrategy;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use PaymentLibrary\Transactions\Transaction;

require_once "../../vendor/autoload.php";

// permet de redirect lien + creer transaction
$factory = new PaymentGatewayFactory();
$paymentGateway = $factory->createPaymentGateway("stripe", ["API_KEY" => Utils::env("API_KEY")]); //Renseigner sa clé d'API dans le .env
$paymentStrategy = new PaymentGatewayStrategy($paymentGateway);
$transaction = $paymentStrategy->createTransaction(0.60, "EUR", "test");
Stripe::setApiKey(Utils::env("API_KEY"));


$paymentStrategy->executeTransaction($transaction);