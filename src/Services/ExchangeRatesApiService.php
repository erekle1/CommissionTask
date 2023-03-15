<?php

namespace Erekle\Commissions\Services;

use Erekle\Commissions\Interfaces\CurrencyExchangeService;
use GuzzleHttp\Client;

/**
 * Class ExchangeRatesApiService
 *
 * A service implementation that retrieves currency exchange rates
 * using the Exchange Rates API (https://exchangeratesapi.io/).
 */
class ExchangeRatesApiService implements CurrencyExchangeService {
    /**
     * @var Client The Guzzle HTTP client used for making API requests to the Exchange Rates API.
     */
    private Client $httpClient;

    /**
     * @var string The API key for accessing the Exchange Rates API.
     */
    private string $apiKey;

    /**
     * ExchangeRatesApiService constructor.
     *
     * @param string $apiKey The API key for the Exchange Rates API.
     * @param string $base_url The base URL for the Exchange Rates API.
     * @param Client|null $httpClient (Optional) An existing Guzzle HTTP client instance.
     */
    public function __construct(string $apiKey, string $base_url, Client $httpClient = null) {
        $this->apiKey = $apiKey;
        // Initialize the Guzzle HTTP client with the provided base URL or use the provided instance
        $this->httpClient = $httpClient ?: new Client(['base_uri' => $base_url]);
    }

    /**
     * Get the exchange rate for the specified currency against the base currency (EUR).
     *
     * @param string $currency The currency code for which to retrieve the exchange rate.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException If an error occurs while making the API request.
     *
     * @return float The exchange rate for the specified currency against the base currency (EUR).
     */
    public function getExchangeRate(string $currency): float {
        // Make an HTTP GET request to the Exchange Rates API to retrieve the latest exchange rates
        $response = $this->httpClient->get('latest', [
            'query' => [
                'access_key' => $this->apiKey
            ]
        ]);

        // Decode the JSON response body
        $data = json_decode($response->getBody()->getContents(), true);

        // Return the exchange rate for the specified currency, or 0 if the currency is not found
        return $data['rates'][$currency] ?? 0;
    }
}
