<?php

namespace PaymentLibrary\Interfaces;

use PaymentLibrary\Transactions\Transaction;
//use State pattern
interface TransactionStatusInterface{
    public function next(Transaction $transaction): void;
    public function prev(Transaction $transaction): void;
    public function getStatusName(): string;
}