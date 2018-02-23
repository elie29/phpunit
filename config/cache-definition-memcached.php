<?php

$servers = array(
    // @@DEMONS_MEMCACHE@@
    array('host' => 'localhost', 'port' => 11211)
);

$memcached = new Memcached();
foreach ($servers as $server) {
    $memcached->addServer($server['host'], $server['port']);
}

$cache = new \Doctrine\Common\Cache\MemcachedCache();
$cache->setMemcached($memcached);

return $cache;