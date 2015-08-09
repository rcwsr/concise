<?php

namespace Concise\Modules\Types;

class IsNotInstanceOf extends IsInstanceOf
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
