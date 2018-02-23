<?php
namespace App\Currency;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests with phpUnit.
 */
class CurrencyTest extends TestCase
{

    /**
     * @expectedException \Exception
     */
    public function testExceptionIsRaisedForEmptyConstructorArgument()
    {
        new Currency('');
    }

    /**
     * @expectedException \Exception
     */
    public function testExceptionIsRaisedForBlankConstructorArgument()
    {
        new Currency('  ');
    }

    public function testCanBeConstructedFromUppercaseString()
    {
        $c = new Currency('EUR');

        $this->assertInstanceOf(Currency::class, $c);

        return $c;
    }

    public function testCanBeConstructedFromLowercaseString()
    {
        $c = new Currency('eur');

        $this->assertInstanceOf(Currency::class, $c);
    }

    public function testCustomCurrencyCanBeRegistered()
    {
        Currency::addCurrency('BTC', 'Bitcoin', 999, 4, 1000);

        $this->assertInstanceOf(Currency::class, new Currency('BTC'));
    }

    public function testRegisteredCurrenciesCanBeAccessed()
    {
        $currencies = Currency::getCurrencies();

        $this->assertInternalType('array', $currencies);
        $this->assertArrayHasKey('EUR', $currencies);
        $this->assertInternalType('array', $currencies['EUR']);
        $this->assertArrayHasKey('display_name', $currencies['EUR']);
        $this->assertArrayHasKey('numeric_code', $currencies['EUR']);
        $this->assertArrayHasKey('default_fraction_digits', $currencies['EUR']);
        $this->assertArrayHasKey('sub_unit', $currencies['EUR']);
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testCanBeCastToString(Currency $c)
    {
        $this->assertEquals('EUR', (string) $c);
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testCurrencyCodeCanBeRetrieved(Currency $c)
    {
        $this->assertEquals('EUR', $c->getCurrencyCode());
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testDisplayNameCanBeRetrieved(Currency $c)
    {
        $this->assertEquals('Euro', $c->getDisplayName());
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testNumericCodeCanBeRetrieved(Currency $c)
    {
        $this->assertEquals(978, $c->getNumericCode());
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testDefaultFractionDigitsCanBeRetrieved(Currency $c)
    {
        $this->assertEquals(2, $c->getDefaultFractionDigits());
    }

    /**
     * @depends testCanBeConstructedFromUppercaseString
     */
    public function testSubUnitCanBeRetrieved(Currency $c)
    {
        $this->assertEquals(100, $c->getSubUnit());
    }
}
