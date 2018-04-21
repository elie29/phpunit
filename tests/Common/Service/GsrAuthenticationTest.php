<?php
namespace Common\Service;

use Stub\KsqTestCase;

class GsrAuthenticationTest extends KsqTestCase
{

    public function testGetPac()
    {
        $gsr = new GsrAuthentication();
        assertThat($gsr->getPac(), is('PAC'));
    }

    public function testGetConnectionParams()
    {
        $gsr = new GsrAuthentication();
        assertThat($gsr->getConnectionParams(), hasEntry('driver', 'oci8'));
    }
}

