<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use WideFocus\Magento\ZendHydratorAdapter\ZendReflectionHydratorAdapter;
use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Zend\Stdlib\Hydrator\Reflection;

/**
 * @coversDefaultClass \WideFocus\Magento\ZendHydratorAdapter\ZendReflectionHydratorAdapter
 */
class ZendReflectionHydratorAdapterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ZendReflectionHydratorAdapter::class,
            new ZendReflectionHydratorAdapter()
        );
    }

    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testParameters()
    {
        $strategies = [
            'foo' => $this->createMock(StrategyInterface::class),
            'bar' => $this->createMock(StrategyInterface::class)
        ];

        $filters = [
            'foo' => $this->createMock(FilterInterface::class),
            'bar' => $this->createMock(FilterInterface::class)
        ];

        $namingStrategy = $this->createMock(NamingStrategyInterface::class);

        $zendHydrator = $this->createMock(Reflection::class);
        $zendHydrator
            ->expects($this->exactly(2))
            ->method('addStrategy')
            ->withConsecutive(
                ['foo', $strategies['foo']],
                ['bar', $strategies['bar']]
            )
            ->willReturnSelf();

        $zendHydrator
            ->expects($this->exactly(2))
            ->method('addFilter')
            ->withConsecutive(
                ['foo', $filters['foo']],
                ['bar', $filters['bar']]
            )
            ->willReturnSelf();

        $zendHydrator
            ->expects($this->once())
            ->method('setNamingStrategy')
            ->with($namingStrategy)
            ->willReturnSelf();

        new ZendReflectionHydratorAdapter(
            $strategies,
            $filters,
            $namingStrategy,
            $zendHydrator
        );
    }
}
