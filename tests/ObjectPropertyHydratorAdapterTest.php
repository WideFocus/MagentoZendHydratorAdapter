<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use PHPUnit\Framework\TestCase;
use WideFocus\Magento\ZendHydratorAdapter\ObjectPropertyHydratorAdapter;

/**
 * @coversDefaultClass \WideFocus\Magento\ZendHydratorAdapter\ObjectPropertyHydratorAdapter
 */
class ObjectPropertyHydratorAdapterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ObjectPropertyHydratorAdapter::class,
            new ObjectPropertyHydratorAdapter()
        );
    }
}
