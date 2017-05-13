<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter\Tests;

use PHPUnit\Framework\TestCase;
use WideFocus\Magento\ZendHydratorAdapter\ClassMethodsHydratorAdapter;

/**
 * @coversDefaultClass \WideFocus\Magento\ZendHydratorAdapter\ClassMethodsHydratorAdapter
 */
class ClassMethodsHydratorAdapterTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ClassMethodsHydratorAdapter::class,
            new ClassMethodsHydratorAdapter()
        );
    }
}
