<?php

namespace Erekle\Commissions\Interfaces;

/**
 * Interface CurrencyExchangeService
 *
 * Defines the contract for a currency exchange service.
 */
interface CurrencyExchangeService
{
    /**
     * Get the exchange rate for the given currency against the base currency.
     *
     * @param string $currency The currency code (e.g., 'USD', 'EUR', 'JPY') to retrieve the exchange rate for.
     *
     * @return float The exchange rate for the given currency against the base currency.
     */
    public function getExchangeRate(string $currency): float;
}
