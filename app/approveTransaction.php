<?php

require __DIR__ . '/../vendor/autoload.php';

use BraintreeDemo\ApiClientBuilder;
use BraintreeDemo\ApiClientConfig;

$config = new ApiClientConfig();

$client = (new ApiClientBuilder($config->getApiEnvironment(),$config->getMerchantId(),$config->getApiKey(),$config->getApiSecret()));

$transactionID = $argv[1];

$transaction = $client->find($transactionID);

print_r("Initial status transaction " . $transactionID . " is " . $transaction->status . "\n");

$result = Braintree\Transaction::submitForSettlement($transactionID);

if ($result->success) {
    $settledTransaction = $result->transaction;
    print_r("Transaction " . $transactionID . " submitted for settlement\n");
} else {
    print_r($result->errors);
}

$transaction = $client->find($transactionID);

print_r("Final status transaction " . $transactionID . " is " . $transaction->status . "\n");