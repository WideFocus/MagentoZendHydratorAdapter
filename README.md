# WideFocus Magento Zend Hydrator Adapter

An adapter to use the Zend Hydrator implementation instead of the Magento2 implementation.

## Installation

Use composer to install the package.

```shell
$ composer require widefocus/magento-zend-hydrator-adapter
```

## Usage

The hydrator implementation in Magento 2.1 works alright with models that do not contain 
any objects. But when a model uses for example `DateTimeInterface` exceptions occur.

This package solves that by making it possible to use the Zend Framework Hydrator.

Example class to be hydrated:

```php
<?php
namespace Foo\Model;

use Foo\Api\Data\FooModelInterface;

class FooModel implements FooModelInterface
{
    private $date;
    
    public function setDate(DateTimeInterface $date)
    {
        $this->date = $date;
    }
    
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}

```

DI configuration (etc/di.xml)

```xml
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    
    <virtualType name="FooHydratorDateTimeStrategy"
                 type="Zend\Stdlib\Hydrator\Strategy\DateTimeFormatterStrategy">
        <arguments>
            <argument name="format" xsi:type="string">Y-m-d H:i:s</argument>
        </arguments>
    </virtualType>
    
    <virtualType name="FooModelHydrator"
                 type="WideFocus\Magento\ZendHydratorAdapter\ReflectionHydratorAdapter">
        <arguments>
            <argument name="strategies" xsi:type="array">
                <item name="date"
                      xsi:type="object">FooHydratorDateTimeStrategy</item>
            </argument>
        </arguments>
    </virtualType>
    
    <type name="Magento\Framework\EntityManager\HydratorPool">
        <arguments>
            <argument name="hydrators" xsi:type="array">
                <item name="Foo\Api\Data\FooModelInterface"
                      xsi:type="string">FooModelHydrator</item>
            </argument>
        </arguments>
    </type>
    
</config>
```

The hydrator will now be used by magento, for example when using the Magento Entity Manager.

The following shows how to get the hydrator from the hydrator pool.

```php
<?php

namespace Foo\Controller;

use Magento\Framework\EntityManager\HydratorPool;
use Foo\Api\Data\FooModelInterface;
use Foo\Model\FooModel;

class Save
{
    private $hydratorPool;
    
    public function __construct(HydratorPool $hydratorPool)
    {
        $this->hydratorPool = $hydratorPool;
    }
    
    public function execute()
    {
        $model = new FooModel();
        $this->hydratorPool
            ->getHydrator(FooModelInterface::class)
            ->hydrate($model, ['date' => '2025-12-31 23:59:59']);
    }
}
```