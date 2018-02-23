<?php
namespace App\Currency;

abstract class CurrenciesDefinition
{

    protected static $currencies = [
        'EUR' => [
            'display_name' => 'Euro',
            'numeric_code' => 978,
            'default_fraction_digits' => 2,
            'sub_unit' => 100
        ],
        'GBP' => [
            'display_name' => 'Pound Sterling',
            'numeric_code' => 826,
            'default_fraction_digits' => 2,
            'sub_unit' => 100
        ],
        'LBP' => [
            'display_name' => 'Lebanese Pound',
            'numeric_code' => 422,
            'default_fraction_digits' => 2,
            'sub_unit' => 100
        ],
        'USD' => [
            'display_name' => 'US Dollar',
            'numeric_code' => 840,
            'default_fraction_digits' => 2,
            'sub_unit' => 100
        ]
    ];

    public static function getCurrencies(): array {
        return self::$currencies;
    }

    public static function addCurrency(string $code, string $displayName, int $numericCode, int $defaultFractionDigits, int $subUnit): void
    {
        self::$currencies[$code] = self::set($displayName, $numericCode, $defaultFractionDigits, $subUnit);
    }

    protected static function set(string $displayName, int $numericCode, int $defaultFractionDigits, int $subUnit): array
    {
        return [
            'display_name' => $displayName,
            'numeric_code' => $numericCode,
            'default_fraction_digits' => $defaultFractionDigits,
            'sub_unit' => $subUnit
        ];
    }
}

