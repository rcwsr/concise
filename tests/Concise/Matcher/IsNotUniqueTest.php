<?php

namespace Concise\Matcher;

class IsNotUniqueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotUnique();
    }

    public function testArrayIsUniqueIfItContainsZeroElements()
    {
        $this->assertFailure(array(), is_not_unique);
    }

    public function testArrayIsNotUniqueIfAnyElementsAppearMoreThanOnce()
    {
        $this->assert(array(123, 456, 123), is_not_unique);
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
