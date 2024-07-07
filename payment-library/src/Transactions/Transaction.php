<?php

namespace PaymentLibrary\Transactions;

use PaymentLibrary\Interfaces\ObserverInterface;
use PaymentLibrary\Interfaces\SubjectInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Status\PendingStatus;

class Transaction implements SubjectInterface{
    private $id;
    private $amount;
    private $currency;
    private $description;
    private $status;
    private array $observers = [];

    public function __construct(float $amount, string $currency, string $description) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->status = new PendingStatus();
    }

    public function attach(ObserverInterface $observer): void{
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void{
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
            $this->observers = array_values($this->observers);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->status);
        }
    }

    public function getId(){
        return $this->id;
    }

    public function setId(int|string $id){
        $this->id = $id;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function setAmount(float $amount){
       $this->amount = $amount;
    }

    public function getCurrency(){
        return $this->currency;
    }

    public function setCurrency(string $currency){
        $this->currency = $currency;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus(TransactionStatusInterface $status){
        $this->status = $status;
        $this->notify();
    }
}