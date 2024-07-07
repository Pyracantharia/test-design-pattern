<?php

namespace PaymentLibrary\Transactions\Status;

use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Transaction;


class CancelledStatus implements TransactionStatusInterface{

    public function next(Transaction $transaction): void {
        $transaction->setStatus(new FailedStatus());
    }

    public function prev(Transaction $transaction): void {
        $transaction->setStatus(new PendingStatus());
    }

    public function getStatusName(): string
    {
        return "canceled";
    }
}