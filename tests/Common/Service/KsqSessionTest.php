<?php
namespace Common\Service;

use Stub\KsqTestCase;

/**
 * KsqSession test case.
 */
class KsqSessionTest extends KsqTestCase
{

    /**
     * @var KsqSession
     */
    private $ksqSession;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->ksqSession = new KsqSession();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ksqSession = null;

        parent::tearDown();
    }

    /**
     * Tests KsqSession->has()
     */
    public function testHas()
    {
        assertThat($this->ksqSession->has('test'), is(false));
    }

    /**
     * Tests KsqSession->set()
     */
    public function testSet()
    {
        $this->ksqSession->set('foo', 'bar');
        assertThat($this->ksqSession->has('foo'), is('bar'));
    }

    /**
     * Tests KsqSession->get()
     */
    public function testGet()
    {
        $this->ksqSession->set('foo', 'bar');
        assertThat($this->ksqSession->get('foo'), is('bar'));
    }

    /**
     * Tests KsqSession->login()
     */
    public function testLogin()
    {
        assertThat($this->ksqSession->isConnected(), is(false));
        $this->ksqSession->login();
        assertThat($this->ksqSession->isConnected(), is(true));
    }

    /**
     * Tests KsqSession->destroyIfNeeded()
     */
    public function testDestroyIfNeeded()
    {
        assertThat($this->ksqSession->destroyIfNeeded(), is(false));
        $this->ksqSession->prepareForDestroy();
        assertThat($this->ksqSession->destroyIfNeeded(), is(true));
    }
}

