<?php
namespace Stub;

use Mockery;
use PHPUnit\Framework\TestCase;

define('BE_PATH', realpath(dirname(dirname(__DIR__))));

/**
 * KsqTestCase test case.
 */
class KsqTestCase extends TestCase
{

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}