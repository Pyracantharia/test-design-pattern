<?php

namespace PaymentLibrary\PaymentGateways;

use PaymentLibrary\Interfaces\PaymentGatewayInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Status\CancelledStatus;
use PaymentLibrary\Transactions\Status\FailedStatus;
use PaymentLibrary\Transactions\Status\PendingStatus;
use PaymentLibrary\Transactions\Status\SuccessStatus;
use PaymentLibrary\Transactions\Transaction;

class StripeGateway implements PaymentGatewayInterface{
    private $credentials;
    private $stripeClient;
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
        $key = $this->credentials["API_KEY"];
        $this->stripeClient = new \Stripe\StripeClient($key);
    }
    
    public function createTransaction(float $amount, string $currency, string $description): Transaction {
        $transaction = new Transaction($amount, $currency, $description);
        try {
            $paymentIntent = $this->stripeClient->paymentIntents->create([ //automatically generates a paymentIntentId
                'amount' => $amount * 100, // Stripe expects amount in cents
                'currency' => $currency,
                'description' => $description,
                'automatic_payment_methods[enabled]' => 'true',
                'automatic_payment_methods[allow_redirects]' => 'never',
            ]);

            // Set the transaction ID with the Stripe PaymentIntent ID
            $transaction->setId($paymentIntent->id);
            $transaction->setStatus(new PendingStatus());
            echo "La transaction {$transaction->getId()} a bien été créé.\n";
        } catch (\Exception $e) {
            // Handle error appropriately
            echo "Error: {$e->getMessage()}";
            $transaction->setStatus(new FailedStatus());
        }

        return $transaction;
    }

    public function executeTransaction(Transaction $transaction): void {
        // Code pour exécuter la transaction via l'API Stripe
        try{
            $this->stripeClient->paymentIntents->confirm(
                $transaction->getId(),
                [
                    'payment_method' => 'pm_card_visa',
                ]
            );
            $transaction->setStatus(new SuccessStatus());
        } catch(\Error $e){
            echo "Erreur: {$e->getMessage()}";
            $transaction->setStatus(new FailedStatus());
        }
    }

    public function cancelTransaction(Transaction $transaction): void {
        try{
            $this->stripeClient->paymentIntents->cancel($transaction->getId(), []);
            $transaction->setStatus(new CancelledStatus());
        } catch(\Error $e){
            $transaction->setStatus(new FailedStatus());
            echo "Echec de l'annulation de la transaction.\n";
        }
        
    }

    public function getTransactionStatus(Transaction $transaction): TransactionStatusInterface {
        return $transaction->getStatus();
    }
}