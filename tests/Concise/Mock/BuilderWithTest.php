<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderWithTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMultipleWithIsAllowedForASingleMethod(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('a')->andReturn('foo')
            ->with('b')->andReturn('bar')
            ->get();
        $this->assert($mock, instance_of, $builder->getClassName());
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMultipleWithCanChangeTheActionOfTheMethod(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('a')->andReturn('foo')
            ->with('b')->andReturn('bar')
            ->get();
        $this->assert($mock->myWithMethod('b'), equals, 'bar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testTheSecondWithActionWillNotOverrideTheFirstOne(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('a')->andReturn('foo')
            ->with('b')->andReturn('bar')
            ->get();
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testSingleWithWithMultipleTimes(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('a')->twice()->andReturn('foo')
            ->get();
        $mock->myWithMethod('a');
        $this->assert($mock->myWithMethod('a'), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStringsInExpectedArgumentsMustBeEscapedCorrectly(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('"foo"')
            ->get();
        $this->assert($mock->myWithMethod('"foo"'), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testStringsWithDollarCharacterMustBeEscaped(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod')->with('a$b')
            ->get();
        $this->assert($mock->myWithMethod('a$b'), is_null);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testWithOnMultipleMethods(MockBuilder $builder)
    {
        $mock = $builder->stub('myWithMethod', 'myMethod')->with('foo')->andReturn('foobar')
            ->get();
        $this->assert($mock->myMethod('foo'), equals, 'foobar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMultipleExpectsUsingTheSameWith(MockBuilder $builder)
    {
        $mock = $builder->expect('myWithMethod')->with('foo')
            ->expect('myMethod')->with('foo')
            ->get();
        $mock->myWithMethod('foo');
        $mock->myMethod('foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMultipleExpectsUsingWith(MockBuilder $builder)
    {
        $mock = $builder->expect('myWithMethod', 'myMethod')->with('foo')
            ->get();
        $mock->myWithMethod('foo');
        $mock->myMethod('foo');
    }

    /**
     * @group #225
     * @dataProvider allBuilders
     */
    public function testMultipleWithsNotBeingFullfilled(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->with('foo')
            ->with('bar')->never()
            ->get();

        $mock->myMethod('foo');
    }

    /**
     * @group #225
     * @dataProvider allBuilders
     */
    public function testMultipleWithsNotBeingFullfilledInDifferentOrder(MockBuilder $builder)
    {
        $mock = $builder->expect('myMethod')->with('bar')->never()
            ->with('foo')
            ->get();

        $mock->myMethod('foo');
    }
}
