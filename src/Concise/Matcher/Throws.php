<?php

namespace Concise\Matcher;

class Throws extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? throws ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		if(!is_callable($data[0])) {
			throw new \Exception("The attribute to test for exception must be callable (an anonymous function)");
		}
		$r = false;
		try {
			$data[0]();
		}
		catch(\Exception $exception) {
			$r = (get_class($exception) === $data[1]);
		}
		
		return $r;
	}
}
