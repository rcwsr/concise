<?php

namespace Concise\Mock;

class MockBuilder
{
	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	protected $rules = array();

	protected $niceMock;

	protected $mockedMethods = array();

	protected $className;

	protected $currentRule;

	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className, $niceMock)
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
		$this->niceMock = $niceMock;
	}

	protected function addRule($method, Action\AbstractAction $action, $times = -1)
	{
		$this->currentRule = $method;
		$this->mockedMethods[] = $method;
		$this->rules[$method] = array(
			'action' => $action,
			'times' => $times,
			'with' => null,
		);
	}

	public function stub($arg)
	{
		if(is_array($arg)) {
			if(count($arg) === 0) {
				throw new \Exception("stub() called with array must have at least 1 element.");
			}
			foreach($arg as $method => $value) {
				$this->addRule($method, new Action\ReturnValueAction($value));
			}
		}
		else {
			$this->addRule($arg, new Action\ReturnValueAction(null));
		}
		return $this;
	}

	protected function getAllMethodNamesForClass()
	{
		$class = new \ReflectionClass($this->className);
		$methodNames = array();
		foreach($class->getMethods() as $method) {
			$methodNames[] = $method->getName();
		}
		return $methodNames;
	}

	protected function stubMethod($mock, $method, $will, $times = -1, $with = null)
	{
		$expect = $this->testCase->any();
		if($times >= 0) {
			$expect = $this->testCase->exactly($times);
		}
		$m = $mock->expects($expect)
				  ->method($method);
		if(null !== $with) {
			$m = call_user_func_array(array($m, 'with'), $with);
		}
		$m->will($will);
	}

	public function done()
	{
		$class = $this->className;
		$originalObject = new $class();

		$allMethods = array_unique($this->getAllMethodNamesForClass() + array_keys($this->rules));
		$mock = $this->testCase->getMock($this->className, $allMethods);
		foreach($this->rules as $method => $rule) {
			$action = $rule['action'];
			$this->stubMethod($mock, $method, $action->getWillAction($this->testCase), $rule['times'], $rule['with']);
		}

		// throw exception for remaining methods
		if($this->niceMock) {
			foreach($allMethods as $method) {
				if(in_array($method, $this->mockedMethods)) {
					continue;
				}
				$will = $this->testCase->returnCallback(array($originalObject, $method));
				$this->stubMethod($mock, $method, $will);
			}
		}
		else {
			foreach($allMethods as $method) {
				if(in_array($method, $this->mockedMethods)) {
					continue;
				}
				$will = $this->testCase->throwException(new \Exception("$method() does not have an associated action - consider a niceMock()?"));
				$this->stubMethod($mock, $method, $will);
			}
		}

		return $mock;
	}

	protected function hasAction()
	{
		$action = $this->rules[$this->currentRule]['action'];
		if($action instanceof Action\ReturnValueAction && is_null($action->getValue())) {
			return false;
		}
		return true;
	}

	protected function setAction(Action\AbstractAction $action)
	{
		if($this->hasAction()) {
			throw new \Exception("{$this->currentRule}() has more than one action attached.");
		}
		$this->rules[$this->currentRule]['action'] = $action;
		return $this;
	}

	public function andReturn($value)
	{
		return $this->setAction(new Action\ReturnValueAction($value));
	}

	public function andThrow($exception)
	{
		return $this->setAction(new Action\ThrowAction($exception));
	}

	public function once()
	{
		$this->exactly(1);
		return $this;
	}

	public function expect($method)
	{
		$this->addRule($method, new Action\ReturnValueAction(null));
		$this->once();
		return $this;
	}

	public function expects($method)
	{
		return $this->expect($method);
	}

	public function twice()
	{
		$this->exactly(2);
		return $this;
	}

	public function never()
	{
		$this->exactly(0);
		return $this;
	}

	public function exactly($times)
	{
		if($times === 0) {
			$this->andReturn(null);
		}
		$this->rules[$this->currentRule]['times'] = $times;
		return $this;
	}

	public function with()
	{
		$this->rules[$this->currentRule]['with'] = func_get_args();
		return $this;
	}
}