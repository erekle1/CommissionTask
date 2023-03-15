<?php

namespace Erekle\Commissions\Services;

use Erekle\Commissions\Interfaces\BinLookupService;
use GuzzleHttp\Client;

/**
 * Class BinlistLookupService
 *
 * A service implementation that performs BIN (Bank Identification Number) lookups
 * using the Binlist API (https://binlist.net/).
 */
class BinlistLookupService implements BinLookupService
{
    /**
     * @var Client The Guzzle HTTP client used for making API requests to the Binlist service.
     */
    private Client $httpClient;

    /**
     * BinlistLookupService constructor.
     *
     * @param string $base_url The base URL for the Binlist API.
     */
    public function __construct(string $base_url)
    {
        // Initialize the Guzzle HTTP client with the provided base URL
        $this->httpClient = new Client(['base_uri' => $base_url]);
    }

    /**
     * Get the country code (alpha-2) associated with the given BIN.
     *
     * @param string $bin The Bank Identification Number to look up.
     *
     * @return string The associated country code (alpha-2).
     */
    public function getCountryCode(string $bin): string
    {
        // Make an HTTP GET request to the Binlist API with the provided BIN
        $response = $this->httpClient->get($bin);

        // Decode the JSON response body
        $data = json_decode($response->getBody()->getContents());

        // Return the country code (alpha-2) from the response data
        return $data->country->alpha2;
    }
}
