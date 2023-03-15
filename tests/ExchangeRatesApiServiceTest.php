<?php

namespace Tests\Erekle\Commissions\Services;

use Erekle\Commissions\Services\ExchangeRatesApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ExchangeRatesApiServiceTest
 *
 * Unit tests for the ExchangeRatesApiService class.
 */
class ExchangeRatesApiServiceTest extends TestCase
{
    /**
     * Test the getExchangeRate method of the ExchangeRatesApiService.
     */
    public function testGetExchangeRate()
    {
        // Prepare mock response data
        $mockResponse = json_encode([
            'rates' => [
                'USD' => 1.1,
                'GBP' => 0.9
            ]
        ]);

        // Create a mock handler with mock responses
        $mockHandler = new MockHandler([
            new Response(200, [], $mockResponse),
            new Response(200, [], $mockResponse),
            new Response(200, [], $mockResponse)
        ]);

        // Create a handler stack using the mock handler
        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient = new Client(['handler' => $handlerStack]);

        // Instantiate the ExchangeRatesApiService with a fake API key and a mocked HTTP client
        $exchangeRatesApiService = new ExchangeRatesApiService('fake_api_key', 'https://api.example.com/', $httpClient);

        // Test fetching USD exchange rate and assert the expected value
        $usdRate = $exchangeRatesApiService->getExchangeRate('USD');
        $this->assertEquals(1.1, $usdRate);

        // Test fetching GBP exchange rate and assert the expected value
        $gbpRate = $exchangeRatesApiService->getExchangeRate('GBP');
        $this->assertEquals(0.9, $gbpRate);

        // Test fetching an unknown currency exchange rate and assert the expected value (0)
        $unknownRate = $exchangeRatesApiService->getExchangeRate('UNKNOWN');
        $this->assertEquals(0, $unknownRate);
    }
}
