<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class ClassMethodsHydratorAdapter extends ZendHydratorAdapter
{
    /**
     * Constructor.
     *
     * @param StrategyInterface[]          $strategies
     * @param FilterInterface[]            $filters
     * @param NamingStrategyInterface|null $namingStrategy
     */
    public function __construct(
        array $strategies = [],
        array $filters = [],
        NamingStrategyInterface $namingStrategy = null
    ) {
        parent::__construct(
            new ClassMethods(),
            $strategies,
            $filters,
            $namingStrategy
        );
    }
}
