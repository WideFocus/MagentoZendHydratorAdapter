<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter;

use Magento\Framework\EntityManager\HydratorInterface;
use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\HydratorInterface as ZendHydratorInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Zend\Stdlib\Hydrator\StrategyEnabledInterface as StdStrategyEnabledInterface;
use Zend\Hydrator\StrategyEnabledInterface;
use Zend\Stdlib\Hydrator\FilterEnabledInterface as StdFilterEnabledInterface;
use Zend\Hydrator\FilterEnabledInterface;
use Zend\Stdlib\Hydrator\NamingStrategyEnabledInterface as StdNamingStrategyEnabledInterface;
use Zend\Hydrator\NamingStrategyEnabledInterface;

class ZendHydratorAdapter implements HydratorInterface
{
    /**
     * @var ZendHydratorInterface
     */
    private $zendHydrator;

    /**
     * Constructor.
     *
     * @param ZendHydratorInterface        $zendHydrator
     * @param StrategyInterface[]          $strategies
     * @param FilterInterface[]            $filters
     * @param NamingStrategyInterface|null $namingStrategy
     */
    public function __construct(
        ZendHydratorInterface $zendHydrator,
        array $strategies = [],
        array $filters = [],
        NamingStrategyInterface $namingStrategy = null
    ) {
        if ($zendHydrator instanceof StrategyEnabledInterface
            || $zendHydrator instanceof StdStrategyEnabledInterface
        ) {
            foreach ($strategies as $name => $strategy) {
                $zendHydrator->addStrategy($name, $strategy);
            }
        }

        if ($zendHydrator instanceof FilterEnabledInterface
            || $zendHydrator instanceof StdFilterEnabledInterface
        ) {
            foreach ($filters as $name => $filter) {
                $zendHydrator->addFilter($name, $filter);
            }
        }

        if ($zendHydrator instanceof NamingStrategyEnabledInterface
            || $zendHydrator instanceof StdNamingStrategyEnabledInterface
        ) {
            $zendHydrator->setNamingStrategy(
                $namingStrategy ?? new UnderscoreNamingStrategy()
            );
        }

        $this->zendHydrator = $zendHydrator;
    }

    /**
     * Extract data from object
     *
     * @param object $entity
     *
     * @return array
     */
    public function extract($entity): array
    {
        return $this->zendHydrator->extract($entity);
    }

    /**
     * Populate entity with data
     *
     * @param object $entity
     * @param array  $data
     *
     * @return object
     */
    public function hydrate($entity, array $data)
    {
        return $this->zendHydrator->hydrate($data, $entity);
    }
}
