<?php

namespace PaymentLibrary\Interfaces;

use PaymentLibrary\Transactions\Transaction;

interface PaymentGatewayStrategyInterface {
    public function setPaymentGateway(PaymentGatewayInterface $gateway): void;
    public function createTransaction(float $amount, string $currency, string $description): Transaction;
    public function executeTransaction(Transaction $transaction): void;
    public function cancelTransaction(Transaction $transaction): void;
    public function getTransactionStatus(Transaction $transaction): TransactionStatusInterface;
}