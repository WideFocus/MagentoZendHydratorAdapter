<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter;

use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class ZendReflectionHydratorAdapter extends ZendHydratorAdapter
{
    /**
     * Constructor.
     *
     * @param StrategyInterface[]          $strategies
     * @param FilterInterface[]            $filters
     * @param NamingStrategyInterface|null $namingStrategy
     * @param Reflection                   $zendHydrator
     */
    public function __construct(
        array $strategies = [],
        array $filters = [],
        NamingStrategyInterface $namingStrategy = null,
        Reflection $zendHydrator = null
    ) {
        $zendHydrator = $zendHydrator ?: new Reflection();

        foreach ($strategies as $name => $strategy) {
            $zendHydrator->addStrategy($name, $strategy);
        }

        foreach ($filters as $name => $filter) {
            $zendHydrator->addFilter($name, $filter);
        }

        $zendHydrator->setNamingStrategy(
            $namingStrategy ?: new UnderscoreNamingStrategy()
        );

        parent::__construct($zendHydrator);
    }
}
