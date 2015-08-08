<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class StringEndsWithTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringEndsWith();
    }

    public function testBasicString()
    {
        $this->assert('"abc" ends with "bc"');
    }

    public function testStringsAreEqual()
    {
        $this->assert('"abc" ends with "abc"');
    }

    public function testStringEndsWithFailure()
    {
        $this->assertFailure('"abc" ends with "ab"');
    }
}
