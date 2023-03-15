<?php

namespace Erekle\Commissions;

/**
 * Class Transaction
 *
 * Represents a transaction containing information about the payment BIN, amount, and currency.
 */
class Transaction
{


    /**
     * Transaction constructor.
     *
     * @param string $bin      The payment card BIN (Bank Identification Number).
     * @param float  $amount   The transaction amount.
     * @param string $currency The transaction currency.
     */
    public function __construct(
        private readonly string $bin,
        private readonly float  $amount,
        private readonly string $currency
    )
    {
    }

    /**
     * Get the payment card BIN (Bank Identification Number).
     *
     * @return string The BIN.
     */
    public function getBin(): string
    {
        return $this->bin;
    }

    /**
     * Get the transaction amount.
     *
     * @return float The transaction amount.
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Get the transaction currency.
     *
     * @return string The transaction currency.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
