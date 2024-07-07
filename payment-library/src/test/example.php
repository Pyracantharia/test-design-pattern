<?php

// namespace Test\Observers;

require_once "../../vendor/autoload.php";

use PaymentLibrary\Core\Utils;
use PaymentLibrary\Factories\PaymentGatewayFactory;
use PaymentLibrary\Strategies\PaymentGatewayStrategy;
// use Stripe\Stripe;
// use Stripe\Checkout\Session;
// use PaymentLibrary\Transactions\Transaction;

use PaymentLibrary\Interfaces\ObserverInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;

// class BillingServiceObserver implements ObserverInterface{
//     public function update(TransactionStatusInterface $transactionStatus): void{
//         echo "BillingService -> the transaction is now: {$transactionStatus->getStatusName()}.\n";
//     }
// }

// require_once "./vendor/autoload.php";
// // permet de redirect lien + creer transaction
// // $factory = new PaymentGatewayFactory();
// // $paymentGateway = $factory->createPaymentGateway("stripe", ["API_KEY" => Utils::env("API_KEY")]); //Renseigner sa clé d'API dans le .env
// // $paymentStrategy = new PaymentGatewayStrategy($paymentGateway);
// // $transaction = $paymentStrategy->createTransaction(0.60, "EUR", "test");
// // Stripe::setApiKey(Utils::env("API_KEY"));


// $session = Session::create([
//     'payment_method_types' => ['card'],
//     'line_items' => [[
//         'price_data' => [
//             'currency' => 'eur',
//             'product_data' => [
//                 'name' => 'Your Product Name',
//             ],
//             'unit_amount' => (int) ($transaction->getAmount() * 100), // Convert amount to cents
//         ],
//         'quantity' => 1,
//     ]],
//     'mode' => 'payment',
//     'success_url' => 'https://your-website.com/success',
//     'cancel_url' => 'https://your-website.com/cancel',
//     'metadata' => [
//         'transaction_id' => $transaction->getId(),
//     ],
// ]);

// header('Location: ' . $session->url);
// exit();

// permet de tester le cancel
// $factory = new PaymentGatewayFactory();
// $paymentGateway = $factory->createPaymentGateway("stripe", ["API_KEY" => Utils::env("API_KEY")]); //Renseigner sa clé d'API dans le .env
// $paymentStrategy = new PaymentGatewayStrategy($paymentGateway);
// $transaction = $paymentStrategy->createTransaction(4.60, "EUR", "test");

// // on va annuler la transaction

// if($transaction->getId() !== null){
//     $paymentStrategy->cancelTransaction($transaction);
//     echo "La transaction a bien été annulée";
// } else {
//     echo "La transaction n'a pas pu être annulée";
// }



// permet executer la transaction
// //$paymentStrategy->executeTransaction($transaction); permet d'exécuter la transaction et donc de la finaliser


// Pour créer un observer
// <?php





//example d'utlisation du package
// use PaymentLibrary\Core\Utils;
// use PaymentLibrary\Factories\PaymentGatewayFactory;
// use PaymentLibrary\Strategies\PaymentGatewayStrategy;
// use Test\Observers\BillingServiceObserver;

$factory = new PaymentGatewayFactory();
$paymentGateway = $factory->createPaymentGateway("stripe",["API_KEY" => Utils::env("API_KEY")]); //Renseigner sa clé d'API dans le .env
$paymentStrategy = new PaymentGatewayStrategy($paymentGateway);
//essayer d'implémenter des services tiers avec observer
$billingservice = new BillingServiceObserver();
$transaction = $paymentStrategy->createTransaction(0.50, "EUR", "test");

// $transaction->attach($billingservice);
// $paymentStrategy->executeTransaction($transaction);

$factory = new PaymentGatewayFactory();

$paypalGateway = $factory->createPaymentGateway("paypal", [
    "PAYPAL_CLIENT_ID" => Utils::env("PAYPAL_CLIENT_ID"),
    "PAYPAL_SECRET_ID" => Utils::env("PAYPAL_SECRET_ID")
    ]
);

$paymentStrategy = new PaymentGatewayStrategy($paypalGateway);
$transaction = $paymentStrategy->createTransaction(0.60, "USD", "test paypal");
