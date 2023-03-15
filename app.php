<?php

// Include the required packages
require __DIR__ . '/vendor/autoload.php';

// Import necessary classes and namespaces
use Erekle\Commissions\Transaction;
use Erekle\Commissions\CommissionCalculator;
use Erekle\Commissions\Services\ExchangeRatesApiService;
use Erekle\Commissions\Services\BinlistLookupService;
use Erekle\Commissions\ServiceContainer;

// Load service configurations
$configServices = require __DIR__ . '/src/config/services.php';

// Initialize a service container with the loaded configurations
$container = new ServiceContainer($configServices);

// Retrieve required services from the container
$exchangeRatesApiService = $container->get(ExchangeRatesApiService::class);
$binlistLookupService = $container->get(BinlistLookupService::class);

/**
 * Parses an input file containing transaction data and returns an array of Transaction objects.
 *
 * @param string $inputFile The path to the input file.
 * @return array An array of Transaction objects.
 */
function parseTransactions(string $inputFile): array {
    $transactions = [];

    // Iterate through each line of the input file and create a Transaction object for each
    foreach (explode("\n", file_get_contents($inputFile)) as $row) {
        if (empty($row)) break;
        $transactionData = json_decode($row, true);
        $transactions[] = new Transaction(
            $transactionData['bin'],
            (float)$transactionData['amount'],
            $transactionData['currency']
        );
    }

    return $transactions;
}

// Read input file path from command line arguments
$inputFile = $argv[1];

// Parse transactions from the input file
$transactions = parseTransactions($inputFile);

// Initialize the CommissionCalculator with required services
$commissionCalculator = new CommissionCalculator($exchangeRatesApiService, $binlistLookupService);

// Calculate and output the commission for each transaction
foreach ($transactions as $transaction) {
    $commission = $commissionCalculator->calculateCommission($transaction);
    echo $commission . "\n";
}
