<?php

namespace Concise\Matcher;

class HasKeyTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasKey();
    }

    public function testArrayHasIntegerKey()
    {
        $this->assert('[123] has key 0');
    }

    public function testKeyDoesNotExist()
    {
        $this->assertFailure('[123] has key 1');
    }

    public function testArrayHasStringKey()
    {
        $this->assert(array("abc" => 123), has_key, "abc");
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }

    /**
     * @expectedException \Concise\Matcher\DidNotMatchException
     */
    public function testFailureThrowsException()
    {
        $this->matcher->match(null, array(array(), 'foo'));
    }

    public function testNestedAssertion()
    {
        $this->assert($this->assert(array("abc" => 123), has_key, "abc"), equals, 123);
    }

    public function testNestedFailureAssertion()
    {
        $this->assertFailure($this->assert(array("abc" => 123), has_key, "abc"), equals, 124);
    }
}
