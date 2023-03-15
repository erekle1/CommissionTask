<?php

// Import the Dotenv library
use Dotenv\Dotenv;

// Create a new Dotenv instance and load the environment variables from the .env file
// located at the project root (two directories up from the current file)
$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();

// Return an array of configuration settings for the project
return [
    // Configuration settings for the Exchange Rates API
    'exchange_rates_api' => [
        // API key for the Exchange Rates API, retrieved from the environment variables
        'key'      => $_ENV['EXCHANGE_RATES_API_KEY'],
        // Base URL for the Exchange Rates API, retrieved from the environment variables
        'base_url' => $_ENV['EXCHANGE_RATES_API_BASE_URL']
    ],
    // Configuration settings for the Binlist API
    'binlist_api'        => [
        // Base URL for the Binlist API, retrieved from the environment variables
        'base_url' => $_ENV['BINLIST_API_BASE_URL']
    ]
];
