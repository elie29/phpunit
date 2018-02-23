<?php
namespace App\Hamcrest;

use PHPUnit\Framework\TestCase;

/**
 * assertThat and not self::assertThat
 * Hamcrest.php is loaded by composer while mockery depends on it.
 */
class HamcrestTest extends TestCase
{

    public function testWithAssertThatPhpunit()
    {
        self::assertThat(2, self::logicalNot(self::equalTo(3)));
        self::assertThat([1, 2], self::containsOnly('int'));
    }

    public function testWithAssertThatHamcrest()
    {
        assertThat('a', is(equalTo('a')));
        assertThat(2, lessThanOrEqualTo(2));
        assertThat(2, lessThanOrEqualTo(3));

        assertThat(3, greaterThanOrEqualTo(3));
        assertThat(3, greaterThanOrEqualTo(2));

        assertThat(2, is(atMost(2)));
        assertThat(2, is(atMost(3)));

        assertThat(3, is(atLeast(3)));
        assertThat(3, is(atLeast(2)));
    }

    public function testWithAssertHamcrestStrings()
    {
        assertThat('this string', is(equalTo('this string')));
        assertThat('this string', equalTo('this string'));
        assertThat('this string', equalToIgnoringCase('ThiS StrIng'));
        assertThat('this string', equalToIgnoringWhiteSpace('   this   string   '));
        assertThat('this string', identicalTo('this string'));

        assertThat('this string', startsWith('th'));
        assertThat('this string', endsWith('ing'));

        assertThat('this string', containsString('str'));
        assertThat('this string', containsStringIgnoringCase('StR'));

        assertThat('this string', matchesPattern('/^this\s*/'));
    }

    public function testStringEmptiness()
    {
        assertThat('', isEmptyString());
        assertThat('', emptyString());
        assertThat('', isEmptyOrNullString());
        assertThat(NULL, isEmptyOrNullString());
        assertThat('', nullOrEmptyString());
        assertThat(NULL, nullOrEmptyString());
        assertThat(NULL, is(nullValue()));

        assertThat('this string', isNonEmptyString());
        assertThat('this string', nonEmptyString());
        assertThat('this string', is(not(emptyString())));
    }

    public function testInclusionsExclusions()
    {
        assertThat('val', is(anyOf('some', 'list', 'of', 'val')));
        assertThat('val', is(noneOf('without', 'the', 'actual', 'value')));

        assertThat('this string', both(containsString('this'))->andAlso(containsString('string')));
        assertThat('this string', either(containsString('this'))->orElse(containsString('that')));

        assertThat('any value, string or object', is(anything()));
    }

    public function testArrayEquality()
    {
        $actualArray = array(1, 2, 3);

        $expectedArray = $actualArray;
        assertThat($actualArray, is(anArray($expectedArray)));
        assertThat($actualArray, equalTo($expectedArray));
    }

    public function testArrayPartials()
    {
        $actualArray = array(1, 2, 3);

        assertThat($actualArray, hasItemInArray(2));
        assertThat($actualArray, hasValue(2)); // Use this shortcut instead of the hasItemInArray

        assertThat($actualArray, arrayContaining(atLeast(0), 2, 3));
        assertThat($actualArray, contains(1, 2, lessThan(4))); // Use this shortcut instead of the arrayContaining
        assertThat($actualArray, not(contains(1, 2))); // size is tested first

        assertThat($actualArray, arrayContainingInAnyOrder(2, 3, 1));
        assertThat($actualArray, containsInAnyOrder(3, 1, 2)); // Use this shortcut instead of the arrayContainingInAnyOrder
    }

    public function testArrayKeys()
    {
        $actualArray['one'] = 1;
        $actualArray['two'] = 2;
        $actualArray['three'] = 3;

        assertThat($actualArray, hasKeyInArray('two'));
        assertThat($actualArray, hasKey('two'));

        assertThat($actualArray, hasKeyValuePair('three', 3));
        assertThat($actualArray, hasEntry('one', 1));
    }

    public function testArraySizes()
    {
        $actualArray = array(1, 2, 3);

        assertThat($actualArray, arrayWithSize(3));
        assertThat($actualArray, nonEmptyArray());
        assertThat([], emptyArray());
    }

    public function testTypeChecks()
    {
        assertThat(NULL, is(nullValue()));
        assertThat('', notNullValue());
        assertThat('', is(not(nullValue())));
        assertThat(TRUE, is(booleanValue()));
        assertThat(123.45, is(numericValue()));
        assertThat(123, is(integerValue()));
        assertThat(123.45, is(floatValue()));
        assertThat('aString', stringValue());
        assertThat(array(1,2,3), arrayValue());
        assertThat(new \stdClass(), objectValue());
        assertThat(new \DomainException(), is(anInstanceOf('DomainException')));
    }

}