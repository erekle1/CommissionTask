<?php

use Erekle\Commissions\CommissionCalculator;
use Erekle\Commissions\Interfaces\BinLookupService;
use Erekle\Commissions\Interfaces\CurrencyExchangeService;
use Erekle\Commissions\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * Class CommissionCalculatorTest
 *
 * Unit tests for the CommissionCalculator class.
 */
class CommissionCalculatorTest extends TestCase
{
    /**
     * Test the calculateCommission method of the CommissionCalculator.
     */
    public function testCalculateCommission()
    {
        // Create mock instances of CurrencyExchangeService and BinLookupService
        $currencyExchangeService = $this->createMock(CurrencyExchangeService::class);
        $binLookupService = $this->createMock(BinLookupService::class);

        // Create test transactions
        $transaction1 = new Transaction('45717360', 100.00, 'EUR');
        $transaction2 = new Transaction('516793', 50.00, 'USD');
        $transaction3 = new Transaction('45417360', 10000.00, 'JPY');
        $transaction4 = new Transaction('41417360', 130.00, 'USD');
        $transaction5 = new Transaction('4745030', 2000.00, 'GBP');

        // Set up the currency exchange rate return values for the mock
        $currencyExchangeService->method('getExchangeRate')
            ->willReturnMap([
                ['EUR', 1],
                ['USD', 1.25],
                ['JPY', 130],
                ['GBP', 0.9],
            ]);

        // Set up the country code return values for the mock
        $binLookupService->method('getCountryCode')
            ->willReturnMap([
                ['45717360', 'FR'],
                ['516793', 'US'],
                ['45417360', 'FR'],
                ['41417360', 'US'],
                ['4745030', 'GB'],
            ]);

        // Instantiate the CommissionCalculator with the mock services
        $commissionCalculator = new CommissionCalculator($currencyExchangeService, $binLookupService);

        // Assert that the calculateCommission method returns the expected commission values
        $this->assertEquals(1.00, $commissionCalculator->calculateCommission($transaction1));
        $this->assertEquals(0.8, $commissionCalculator->calculateCommission($transaction2));
        $this->assertEquals(0.77, $commissionCalculator->calculateCommission($transaction3)); // Updated the expected value
        $this->assertEquals(2.08, $commissionCalculator->calculateCommission($transaction4));
        $this->assertEquals(44.45, $commissionCalculator->calculateCommission($transaction5));
    }
}
