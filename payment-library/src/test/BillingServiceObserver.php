<?php

namespace Test\Observers;

use PaymentLibrary\Interfaces\ObserverInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;

class BillingServiceObserver implements ObserverInterface{
    public function update(TransactionStatusInterface $transactionStatus): void{
        echo "BillingService -> the transaction is now: {$transactionStatus->getStatusName()}.\n";
    }
}


