# PqSqlRoundFunction
ROUND() function implementation for Doctrine DQL

[![Latest Stable Version](https://poser.pugx.org/kspitfire/pgsql-doctrine-round-function/v/stable)](https://packagist.org/packages/kspitfire/pgsql-doctrine-round-function)
[![Total Downloads](https://poser.pugx.org/kspitfire/pgsql-doctrine-round-function/downloads)](https://packagist.org/packages/kspitfire/pgsql-doctrine-round-function)
[![License](https://poser.pugx.org/kspitfire/pgsql-doctrine-round-function/license)](https://packagist.org/packages/kspitfire/pgsql-doctrine-round-function)


## Installation
```bash
$ composer require kspitfire/pgsql-doctrine-round-function
```

## Configuration
```yaml
# app/config/config.yml

doctrine:
    orm:
        # ...
        dql:
            numeric_functions:
                Round: Kspitfire\PgSqlRoundFunction\DQL\RandomFunction
```

## Usage
```php
$em = $this->get('doctrine.orm.default_entity_manager');

// with precision
$resultWithPrecision = $em->getRepository(Entity::class)
    ->createQueryBuilder('e')
    ->select('ROUND(e.fieldName / 15, 2) as num')
    ->setMaxResults(1)
    ->getQuery()
    ->getSingleScalarResult();

// without precision
$resultWithoutPrecision = $em->getRepository(Entity::class)
    ->createQueryBuilder('e')
    ->select('ROUND(e.fieldName / 15) as num')
    ->setMaxResults(1)
    ->getQuery()
    ->getSingleScalarResult();
```