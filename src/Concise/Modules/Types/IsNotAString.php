<?php

namespace Concise\Modules\Types;

class IsNotAString extends IsAString
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
