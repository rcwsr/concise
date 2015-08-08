<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class StringDoesNotEndWithTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringDoesNotEndWith();
    }

    public function testNeedleLongerThanHaystack()
    {
        $this->assert('"abc" does not end with "abcd"');
    }

    public function testStringDoesNotStartWithAnotherString()
    {
        $this->assert('"abc" does not end with "a"');
    }

    public function testStringDoesNotEndWithFailure()
    {
        $this->assertFailure('"abc" does not end with "abc"');
    }
}
