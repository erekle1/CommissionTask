<?php

namespace Erekle\Commissions;

use Erekle\Commissions\Interfaces\BinLookupService;
use Erekle\Commissions\Interfaces\CurrencyExchangeService;

/**
 * Class CommissionCalculator
 *
 * A class for calculating commissions on transactions based on the
 * country of the transaction and the currency conversion rate.
 */
class CommissionCalculator
{
    /**
     * CommissionCalculator constructor.
     *
     * @param CurrencyExchangeService $currencyExchangeService An instance of a CurrencyExchangeService for exchange rate lookup.
     * @param BinLookupService $binLookupService An instance of a BinLookupService for BIN lookup.
     */
    public function __construct(
        private readonly CurrencyExchangeService $currencyExchangeService,
        private readonly BinLookupService $binLookupService
    )
    {
    }

    /**
     * Calculate the commission for a given transaction.
     *
     * @param Transaction $transaction The transaction for which to calculate the commission.
     *
     * @return float The commission amount for the transaction.
     */
    public function calculateCommission(Transaction $transaction): float
    {
        // Get the exchange rate for the transaction currency
        $rate = $this->currencyExchangeService->getExchangeRate($transaction->getCurrency());

        // Calculate the fixed amount in EUR
        $amntFixed = $transaction->getCurrency() == 'EUR' || $rate == 0
            ? $transaction->getAmount()
            : $transaction->getAmount() / $rate;

        // Determine if the transaction is made in the EU
        $isEu = $this->isEu($this->binLookupService->getCountryCode($transaction->getBin()));

        // Calculate the commission based on whether the transaction is made in the EU or not
        $commission = $amntFixed * ($isEu ? 0.01 : 0.02);

        // Round up the commission to the nearest cent
        return $this->roundUp($commission);
    }

    /**
     * Check if the given country code is within the European Union.
     *
     * @param string $countryCode The 2-letter country code to check.
     *
     * @return bool True if the country is in the EU, false otherwise.
     */
    private function isEu(string $countryCode): bool
    {
        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
        return in_array($countryCode, $euCountries);
    }

    /**
     * Round up a given float value to the specified precision.
     *
     * @param float $value The value to round up.
     * @param int $precision (Optional) The number of decimal places to round up to. Defaults to 2.
     *
     * @return float The rounded up value.
     */
    private function roundUp(float $value, int $precision = 2): float
    {
        $multiplier = 10 ** $precision;
        return ceil($value * $multiplier) / $multiplier;
    }

}
