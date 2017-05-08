<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;
use WideFocus\Magento\ZendHydratorAdapter\ZendHydratorAdapter;
use Zend\Stdlib\Hydrator\HydratorInterface;

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
