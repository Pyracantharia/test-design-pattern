<?php

namespace PaymentLibrary\Strategies;

use PaymentLibrary\Interfaces\PaymentGatewayInterface;
use PaymentLibrary\Interfaces\PaymentGatewayStrategyInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Transaction;

class PaymentGatewayStrategy implements PaymentGatewayStrategyInterface{
    public function __construct(private PaymentGatewayInterface $gateway){}

    public function setPaymentGateway(PaymentGatewayInterface $gateway): void
    {
        $this->gateway = $gateway;
    }

    public function createTransaction(float $amount, string $currency, string $description): Transaction
    {
        return $this->gateway->createTransaction($amount, $currency, $description);
    }

    public function executeTransaction(Transaction $transaction): void
    {
        $this->gateway->executeTransaction($transaction);
    }

    public function cancelTransaction(Transaction $transaction): void{
        $this->gateway->cancelTransaction($transaction);
    }

    public function getTransactionStatus(Transaction $transaction): TransactionStatusInterface
    {
        return $this->gateway->getTransactionStatus($transaction);
    }
}