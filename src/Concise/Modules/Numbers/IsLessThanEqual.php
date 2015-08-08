<?php

namespace Concise\Modules\Numbers;

use Concise\Matcher\AbstractMatcher;

class IsLessThanEqual extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] <= $data[1];
    }

    public function getTags()
    {
        return array();
    }
}
