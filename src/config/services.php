<?php

// Import the necessary classes and interfaces
use Erekle\Commissions\Services\ExchangeRatesApiService;
use Erekle\Commissions\Services\BinlistLookupService;
use Psr\Container\ContainerInterface;

// Load the configuration settings from the config.php file
$config = require __DIR__ . '/config.php';

// Return an array of service definitions for the dependency container
return [
    // Define the ExchangeRatesApiService as a singleton service
    ExchangeRatesApiService::class => function (ContainerInterface $container) use ($config) {
        // Instantiate the ExchangeRatesApiService with the required configuration settings
        return new ExchangeRatesApiService(
        // Pass the API key for the Exchange Rates API from the config
            $config['exchange_rates_api']['key'],
            // Pass the base URL for the Exchange Rates API from the config
            $config['exchange_rates_api']['base_url']
        );
    },
    // Define the BinlistLookupService as a singleton service
    BinlistLookupService::class => function (ContainerInterface $container) use($config) {
        // Instantiate the BinlistLookupService with the required configuration settings
        return new BinlistLookupService(
        // Pass the base URL for the Binlist API from the config
            $config['binlist_api']['base_url']
        );
    },
];
