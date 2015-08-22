<?php

namespace Concise\Matcher;

use InvalidArgumentException;

class Syntax
{
    /**
     * @var string
     */
    protected $syntax;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var bool
     */
    protected $nested;

    public function __construct($syntax, $method, $nested = false)
    {
        if (strpos($method, '::') === false) {
            throw new InvalidArgumentException(
                "Method must be in the form of <class>::<method>"
            );
        }
        list($this->class, $this->method) = explode("::", $method);
        if (!class_exists($this->class)) {
            throw new InvalidArgumentException(
                "Class '$this->class' does not exist."
            );
        }
        $this->syntax = $syntax;
        $this->nested = $nested;
    }

    /**
     * @var string
     */
    public function getSyntax()
    {
        return $this->syntax;
    }

    /**
     * @var string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @var string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @var string
     */
    public function getRawSyntax()
    {
        return preg_replace('/\\?:[^\s$]+/i', '?', $this->syntax);
    }

    /**
     * @var string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isNested()
    {
        return $this->nested;
    }
}
