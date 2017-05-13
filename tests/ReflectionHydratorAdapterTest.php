<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use PHPUnit\Framework\TestCase;
use WideFocus\Magento\ZendHydratorAdapter\ReflectionHydratorAdapter;

/**
 * @coversDefaultClass \WideFocus\Magento\ZendHydratorAdapter\ReflectionHydratorAdapter
 */
class ReflectionHydratorAdapterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ReflectionHydratorAdapter::class,
            new ReflectionHydratorAdapter()
        );
    }
}
