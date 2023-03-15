<?php

namespace Erekle\Commissions\Interfaces;

/**
 * Interface BinLookupService
 *
 * Defines the contract for a BIN (Bank Identification Number) lookup service.
 */
interface BinLookupService {
    /**
     * Get the country code (alpha-2) associated with the given BIN.
     *
     * @param string $bin The Bank Identification Number to look up.
     *
     * @return string The associated country code (alpha-2).
     */
    public function getCountryCode(string $bin): string;
}
