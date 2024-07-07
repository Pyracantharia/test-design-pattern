<?php

namespace PaymentLibrary\Interfaces;

interface ObserverInterface {
    public function update(TransactionStatusInterface $transactionStatus): void;
}