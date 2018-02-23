# Unit tests

## Documentation
[Assert](https://github.com/beberlei/assert)
[PHP-DI](http://php-di.org/doc/)
[Zend Expressive](https://docs.zendframework.com/zend-expressive/)
[Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/index.html)
[PHPUnit](https://phpunit.readthedocs.io/fr/latest/)
[Hamcrest](https://github.com/hamcrest/hamcrest-php)
[Mockery](http://docs.mockery.io/en/latest)

## Project overview
- Frontend controller: public/index.php
- Application source files: src/App
- Application test files: tests/App

## Text file enconding
- UTF-8

## Code style formatter
- PSR-2

## Global constants
   - **DEV_MODE**: boolean - true in dev environment.
   - **BE_PATH**: string - Full path to backend folder.

## Backend structure
   - **build**: Used by phpunit to deploy logs and html coverage files.
   - **cache**: Used by some dependencies for cached files
   - **config**: Contains routes and php-di config definitions.
   - **public**: Front controller api accessed from outside.
   - **script**: Useful PHP scripting files.
   - **src**: Entities, services and middleware classes dispatched into modules eg:
      - Common: Common classes for all modules
      - Entretien: Entretien module:
         - Entity: ORM Entity for each table related to entretien.
         - Middleware: Middleware Actions and pipes.
         - Repository: Sql queries.
         - Service: Specific business classes.
   - **tests**: Tests classes.
   - **vendor**: Dependencies classes.
   - **cli-config.php**: Used in testing and doctrine console.
   - **composer.json**: Dependencies configuration.
   - **phpunit.xml**: Phpunit configuration.

### cache and build folders
- Should be writable
- Must be cleared on each deployment in production

## Install dependencies
Run `composer install`

## Launch project
Run `composer serve`

## Project seed
Run `git checkout master`

## Final project
Run `git checkout final-project`

## Doctrine console

### Command Overview
Run `vendor/bin/doctrine list`

### Entity creation
Run `vendor/bin/doctrine orm:convert-mapping --namespace="App\Demo\Entity\\" --force  --from-database annotation ./src/`
- `--force` to overwrite existing entities

### Setter/Getter generation
- On specific entity, run `vendor/bin/doctrine orm:generate-entities --filter=App\Demo\Entity\TCompteurs ./src/`
- For all entities, run `vendor/bin/doctrine orm:generate-entities ./src/`
