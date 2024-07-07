<?php

namespace PaymentLibrary\Factories;

use Error;
use PaymentLibrary\Interfaces\PaymentGatewayFactoryInterface;
use PaymentLibrary\Interfaces\PaymentGatewayInterface;
use PaymentLibrary\PaymentGateways\PaypalGateway;
use PaymentLibrary\PaymentGateways\StripeGateway;

/**
 * @param string $name name of the payment interface
 * @param array $credentials an array of all your credentials
 */
class PaymentGatewayFactory implements PaymentGatewayFactoryInterface{
    public function createPaymentGateway(string $name, array $credentials): PaymentGatewayInterface{
        return match ($name) {
            "stripe" => new StripeGateway($credentials),
            "paypal" => new PaypalGateway($credentials),
            default => throw new Error("Interface de paiement non supportée.")
        };
    }
}