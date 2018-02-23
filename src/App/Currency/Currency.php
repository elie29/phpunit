<?php
namespace App\Currency;

use Assert\Assertion;

final class Currency extends CurrenciesDefinition
{

    private $code;

    public function __construct(string $currencyCode)
    {
        Assertion::notBlank($currencyCode);
        $this->code = strtoupper($currencyCode);
        Assertion::keyExists(self::$currencies, $this->code);
    }

    public function getCurrencyCode(): string
    {
        return $this->code;
    }

    public function getDisplayName(): string
    {
        return self::$currencies[$this->code]['display_name'];
    }

    public function getNumericCode(): int
    {
        return self::$currencies[$this->code]['numeric_code'];
    }

    public function getDefaultFractionDigits(): int
    {
        return self::$currencies[$this->code]['default_fraction_digits'];
    }

    public function getSubUnit(): int
    {
        return self::$currencies[$this->code]['sub_unit'];
    }

    public function __toString(): string
    {
        return $this->code;
    }
}

