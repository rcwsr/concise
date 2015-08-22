<?php

namespace Concise\Matcher;

use Concise\Services\SyntaxRenderer;
use ReflectionClass;
use ReflectionMethod;

abstract class AbstractMatcher
{
    public $data = array();

    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function renderFailureMessage($syntax, array $data = array())
    {
        $renderer = new SyntaxRenderer();

        return $renderer->render($syntax, $data);
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    protected function getSyntaxesFromMethod(ReflectionMethod $method)
    {
        $doc = $method->getDocComment();
        $m = $method->getName();
        $isNested = strpos($doc, '@nested') !== false;
        $syntaxes = array();

        foreach (explode("\n", $doc) as $line) {
            $pos = strpos($line, '@syntax');

            // Ignore lines that are not a syntax.
            if ($pos === false) {
                continue;
            }

            $syntaxes[] = new Syntax(
                trim(substr($line, $pos + 7)),
                $method->getDeclaringClass()->getName() .
                '::' .
                $m,
                $isNested
            );
        }

        return $syntaxes;
    }

    /**
     * @return Syntax[]
     */
    public function getSyntaxes()
    {
        $reflectionClass = new ReflectionClass($this);
        $methods = array();
        foreach ($reflectionClass->getMethods() as $method) {
            $methods = array_merge(
                $methods,
                $this->getSyntaxesFromMethod($method)
            );
        }

        return $methods;
    }
}
