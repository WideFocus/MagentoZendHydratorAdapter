<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;
use WideFocus\Magento\ZendHydratorAdapter\ZendHydratorAdapter;
use Zend\Stdlib\Hydrator\Filter\FilterInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * @coversDefaultClass \WideFocus\Magento\ZendHydratorAdapter\ZendHydratorAdapter
 */
class ZendHydratorAdapterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ZendHydratorAdapter::class,
            new ZendHydratorAdapter(
                $this->createMock(HydratorInterface::class)
            )
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

        new ZendHydratorAdapter(
            $zendHydrator,
            $strategies,
            $filters,
            $namingStrategy
        );
    }

    /**
     * @return void
     *
     * @covers ::extract
     */
    public function testExtract()
    {
        $object = $this->createMock(stdClass::class);
        $result = ['some_result'];

        $zendHydrator = $this->createMock(HydratorInterface::class);
        $zendHydrator
            ->expects($this->once())
            ->method('extract')
            ->with($object)
            ->willReturn($result);

        $hydrator = new ZendHydratorAdapter($zendHydrator);
        $this->assertEquals(
            $result,
            $hydrator->extract($object)
        );
    }

    /**
     * @return void
     *
     * @covers ::hydrate
     */
    public function testHydrate()
    {
        $object = $this->createMock(stdClass::class);
        $data   = ['some_result'];

        $zendHydrator = $this->createMock(HydratorInterface::class);
        $zendHydrator
            ->expects($this->once())
            ->method('hydrate')
            ->with($data, $object)
            ->willReturn($object);

        $hydrator = new ZendHydratorAdapter($zendHydrator);
        $this->assertSame(
            $object,
            $hydrator->hydrate($object, $data)
        );
    }
}
