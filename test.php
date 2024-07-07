<?php

use PaymentLibrary\Core\Utils;
use PaymentLibrary\Factories\PaymentGatewayFactory;
use PaymentLibrary\Strategies\PaymentGatewayStrategy;

require_once __DIR__."/payment-library/vendor/autoload.php";

$factory = new PaymentGatewayFactory();
$gateway = $factory->createPaymentGateway("stripe", ["API_KEY" => Utils::env("API_KEY")]);
$gatewayStrategy = new PaymentGatewayStrategy($gateway);
$transaction = $gatewayStrategy->createTransaction(0.60, "EUR", "Test d'implémentation");
$gatewayStrategy->executeTransaction($transaction);