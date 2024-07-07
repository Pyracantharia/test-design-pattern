<?php

namespace PaymentLibrary\Transactions\Status;

use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Transaction;
use PaymentLibrary\Transactions\Status\PendingStatus;

class SuccessStatus implements TransactionStatusInterface{
    
    public function next(Transaction $transaction): void {
        //already in final state
    }

    public function prev(Transaction $transaction): void {
        $transaction->setStatus(new PendingStatus());
    }

    public function getStatusName(): string
    {
        return "success";
    }
}