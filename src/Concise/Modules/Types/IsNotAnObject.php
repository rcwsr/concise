<?php

namespace Concise\Modules\Types;

class IsNotAnObject extends IsAnObject
{
    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
