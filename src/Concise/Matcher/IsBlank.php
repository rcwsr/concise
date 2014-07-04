<?php

namespace Concise\Matcher;

class IsBlank extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'?:string is blank' => 'Assert a string is zero length.',
		);
	}

	public function match($syntax, array $data = array())
	{
		return true;
	}
}
