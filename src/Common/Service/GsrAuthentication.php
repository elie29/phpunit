<?php

namespace Common\Service;

class GsrAuthentication
{

    public function getPac()
    {
        return 'PAC';
    }

    /**
     * cf. http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
     * @return array
     */
    public function getConnectionParams()
    {
        return array(
            // Database configuration parameters
            'driver' => 'oci8',
            'user' => '',
            'password' => '',
            'host' => '',
            'port' => 12019,
            'dbname' => '',
            'charset' => 'UTF8',
            'persistent' => true,
            'pooled' => false // DRCP NOT ACTIVATED YET !!
        );
    }
}

