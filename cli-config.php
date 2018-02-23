<?php

/**
 * This file is used by doctrine command line.
 */
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Event\Listeners\OracleSessionInit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

require 'vendor/autoload.php';

// 1. Create the annotation driver based on its reader
$pathsToEntities = [realpath(__DIR__ . '/src')];

// 2. Create default annotation configuration with @ORM\Entity
$config = Setup::createAnnotationMetadataConfiguration($pathsToEntities, true, null, null, false);

// 3. EventManager for Oracle Session
$eventManager = new EventManager();
$eventManager->addEventSubscriber(new OracleSessionInit());

// 4. Create the entity manager
$entityManager = EntityManager::create([
    'driver' => 'oci8',
    'user' => '',
    'password' => '',
    'host' => '',
    'port' => 12019,
    'dbname' => '',
    'charset' => 'UTF8',
    'persistent' => true,
    'pooled' => false // DRCP NOT ACTIVATED YET !!
], $config, $eventManager);

// 5. Needed only for orm:covert-mapping purpose
$filter_include = [
  '^T_CATEGORIE$',
  'T_CAMPAGNE$',
  'T_COMPETENCE$',
  'T_EMAIL$',
  // 'another_table_name',
  // '.*some_sub_portion.*',
  // '^some_table_prefix_.*',
  // '.*some_table_suffix$'
];
$include_reg = '/^(' . implode('|', $filter_include) . ').*$/';
$entityManager->getConfiguration()->setFilterSchemaAssetsExpression($include_reg);

return ConsoleRunner::createHelperSet($entityManager);