<?php

use Erekle\Commissions\Services\BinlistLookupService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class BinlistLookupServiceTest
 *
 * Unit tests for the BinlistLookupService class.
 */
class BinlistLookupServiceTest extends TestCase
{
    /**
     * Test the getCountryCode method of the BinlistLookupService.
     */
    public function testGetCountryCode()
    {
        // Mock API response for the binlist service
        $mockResponse = '{"number":{"length":16,"luhn":true},"scheme":"visa","type":"debit","brand":"Traditional","country":{"numeric":"840","alpha2":"US","name":"United States of America","emoji":"🇺🇸"},"bank":{}}';

        // Create a MockHandler to handle the API request
        $mockHandler = new MockHandler([
            new Response(200, [], $mockResponse),
        ]);

        // Create a HandlerStack with the MockHandler
        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient = new Client(['handler' => $handlerStack, 'base_uri' => 'https://lookup.binlist.net/']);

        // Instantiate the BinlistLookupService
        $binlistLookupService = new BinlistLookupService('https://lookup.binlist.net/');

        // Use Reflection to inject the mocked httpClient into the BinlistLookupService
        $binlistLookupServiceReflection = new \ReflectionClass($binlistLookupService);
        $httpClientProperty = $binlistLookupServiceReflection->getProperty('httpClient');
        $httpClientProperty->setAccessible(true);
        $httpClientProperty->setValue($binlistLookupService, $httpClient);

        // Test data
        $bin = '45717360';
        $expectedCountryCode = 'US';

        // Assert that the getCountryCode method returns the expected country code
        $this->assertEquals($expectedCountryCode, $binlistLookupService->getCountryCode($bin));
    }
}
