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
        if ($zendHydrator instanceof NamingStrategyEnabledInterface
            || $zendHydrator instanceof StdNamingStrategyEnabledInterface
        ) {
            $namingStrategy = $namingStrategy ?? new UnderscoreNamingStrategy();
            $strategies     = $this->expandNames($namingStrategy, $strategies);
            $filters        = $this->expandNames($namingStrategy, $filters);

            $zendHydrator->setNamingStrategy($namingStrategy);
        }

        $this->setStrategies($zendHydrator, $strategies);
        $this->setFilters($zendHydrator, $filters);

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

    /**
     * Set the strategies if supported.
     *
     * @param ZendHydratorInterface $zendHydrator
     * @param StrategyInterface[]   $strategies
     *
     * @return void
     */
    private function setStrategies(
        ZendHydratorInterface $zendHydrator,
        array $strategies
    ) {
        if ($zendHydrator instanceof StrategyEnabledInterface
            || $zendHydrator instanceof StdStrategyEnabledInterface
        ) {
            foreach ($strategies as $name => $strategy) {
                $zendHydrator->addStrategy($name, $strategy);
            }
        }
    }

    /**
     * Set the filters if supported.
     *
     * @param ZendHydratorInterface $zendHydrator
     * @param FilterInterface[]     $filters
     *
     * @return void
     */
    private function setFilters(
        ZendHydratorInterface $zendHydrator,
        array $filters
    ) {
        if ($zendHydrator instanceof FilterEnabledInterface
            || $zendHydrator instanceof StdFilterEnabledInterface
        ) {
            foreach ($filters as $name => $filter) {
                $zendHydrator->addFilter($name, $filter);
            }
        }
    }

    /**
     * Use hydration names and extraction names for strategies and filters.
     *
     * @param NamingStrategyInterface $namingStrategy
     * @param array                   $objects
     *
     * @return array
     *
     * @see https://github.com/zendframework/zend-hydrator/issues/46
     */
    private function expandNames(
        NamingStrategyInterface $namingStrategy,
        array $objects
    ): array {
        $extractionNames = array_map(
            function (string $name) use ($namingStrategy) : string {
                return $namingStrategy->extract($name) ?? $name;
            },
            array_keys($objects)
        );

        $hydrationNames = array_map(
            function (string $name) use ($namingStrategy) : string {
                return $namingStrategy->hydrate($name) ?? $name;
            },
            array_keys($objects)
        );

        return array_combine($extractionNames, array_values($objects))
            + array_combine($hydrationNames, array_values($objects));
    }
}
