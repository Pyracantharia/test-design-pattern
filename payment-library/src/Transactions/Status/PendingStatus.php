<?php

namespace PaymentLibrary\Transactions\Status;

use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PaymentLibrary\Transactions\Transaction;
use PaymentLibrary\Transactions\Status\SuccessStatus;

class PendingStatus implements TransactionStatusInterface{

    public function next(Transaction $transaction): void {
        if ($this->isPaymentSuccessful($transaction)) {
            $transaction->setStatus(new SuccessStatus());
        } elseif ($this->isPaymentFailed($transaction)) {
            $transaction->setStatus(new FailedStatus());
        } elseif ($this->isPaymentCancelled($transaction)) {
            $transaction->setStatus(new CancelledStatus());
        }
    }

    public function prev(Transaction $transaction): void {
        
    }

    private function isPaymentFailed(Transaction $transaction): bool {
        return false; //Vous pouvez remplacer cette partie par une logique réelle
    }

    private function isPaymentSuccessful(Transaction $transaction): bool {
        return true; // Simule une réussite de paiement aléatoire ,Vous pouvez remplacer cette partie par une logique réelle
    }

    private function isPaymentCancelled(Transaction $transaction): bool {
        // Logique simulée pour vérifier si le paiement est annulé
        // Vous pouvez remplacer cette partie par une logique réelle
        return false; // Modifiez selon la logique réelle
    }

    public function getStatusName(): string {
        return 'pending';
    }
}
