<?php

namespace PaymentLibrary\Interfaces;

interface PaymentGatewayFactoryInterface{
    public function createPaymentGateway(string $name, array $credentials): PaymentGatewayInterface;
}
