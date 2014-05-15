<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class BooleanTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Boolean();
	}

	public function _test_comparisons()
	{
		$this->x = true;
		$this->b = false;
		return array(
			'true',
			'x is true',
			'b is false'
		);
	}
}
