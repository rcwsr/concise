<?php

namespace Concise;

class MatcherParser
{
	public function compile($string)
	{
		return new \Concise\Matcher\EqualTo();
	}
}