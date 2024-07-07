<?php

namespace PaymentLibrary\PaymentGateways;

use Error;
use PaymentLibrary\Interfaces\PaymentGatewayInterface;
use PaymentLibrary\Interfaces\TransactionStatusInterface;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment as PaypalPayment;
use Exception;
use PaymentLibrary\Transactions\Status\CancelledStatus;
use PaymentLibrary\Transactions\Status\FailedStatus;
use PaymentLibrary\Transactions\Status\SuccessStatus;
use PaymentLibrary\Transactions\Transaction;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;

class PaypalGateway implements PaymentGatewayInterface
{
    private $credentials;
    private $api_context;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
        $this->api_context = new ApiContext(
            new OAuthTokenCredential($this->credentials['PAYPAL_CLIENT_ID'], $this->credentials['PAYPAL_SECRET_ID'])
        );
        $this->api_context->setConfig(["mode" => "sandbox"]);
    }

    public function createTransaction($amount, $currency, $description): Transaction
    {
        $transaction = new Transaction($amount, $currency, $description);

        $payer = (new Payer())->setPaymentMethod('paypal');
        $redirectUrls = (new RedirectUrls())
            ->setReturnUrl("http://example.com/your_redirect_url_here")
            ->setCancelUrl("http://example.com/your_cancel_url_here");

        $payment = (new PaypalPayment())
            ->setIntent('authorize')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([[
                'amount' => ['currency' => $currency, 'total' => $amount],
                'description' => $description
            ]]);
        
        try{
            $payment->create($this->api_context);
            $transaction->setId($payment->getId());
            echo "La transaction {$transaction->getId()} a bien été créé.\n";
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $approvalUrl = $link->getHref();
                    // "Approval URL: " . $approvalUrl
                    header("Location: $approvalUrl");
                }
            }
        } catch(Error $e){
            echo "Erreur: {$e->getMessage()}";
            $transaction->setStatus(new FailedStatus());
        }
        
        return $transaction;
    }

    public function executeTransaction(Transaction $transaction): void
    {
        // Implement transaction execution logic here
        // Simulate a pending status for now
        $transaction->setStatus(new SuccessStatus());
    }

    
    public function cancelTransaction(Transaction $transaction): void
    {
        // Implement transaction cancellation logic here
        // For now, just set the status to cancelled
        $transaction->setStatus(new CancelledStatus());
    }

    public function getTransactionStatus(Transaction $transaction): TransactionStatusInterface
    {
        return $transaction->getStatus();
    }
}
