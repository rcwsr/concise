<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class AbstractResultPrinterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\AbstractResultPrinter')->done();
    }

    public function testResultPrinterImplementsTestResultDelegateInterface()
    {
        $this->assert($this->resultPrinter, instance_of, 'Concise\Console\TestRunner\TestResultDelegateInterface');
    }

    public function testDefaultSuccessCountIsZero()
    {
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 0);
    }

    public function testDefaultFailureCountIsZero()
    {
        $this->assert($this->resultPrinter->getFailureCount(), exactly_equals, 0);
    }

    public function testDefaultErrorCountIsZero()
    {
        $this->assert($this->resultPrinter->getErrorCount(), exactly_equals, 0);
    }

    public function testDefaultIncompleteCountIsZero()
    {
        $this->assert($this->resultPrinter->getIncompleteCount(), exactly_equals, 0);
    }

    public function testDefaultRiskyCountIsZero()
    {
        $this->assert($this->resultPrinter->getRiskyCount(), exactly_equals, 0);
    }

    public function testDefaultSkippedCountIsZero()
    {
        $this->assert($this->resultPrinter->getSkippedCount(), exactly_equals, 0);
    }

    public function testDefaultTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTestCount(), exactly_equals, 0);
    }

    public function testDefaultTotalTestCountIsZero()
    {
        $this->assert($this->resultPrinter->getTotalTestCount(), exactly_equals, 0);
    }

    public function testDefaultAssertionCountIsZero()
    {
        $this->assert($this->resultPrinter->getAssertionCount(), exactly_equals, 0);
    }

    public function testSuccessCountIsTheTestCount()
    {
        $this->resultPrinter->testCount = 20;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 20);
    }

    public function testSuccessCountWillNotIncludeSkipped()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->skippedCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeFailures()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->failureCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeErrors()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->errorCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeIncompleteTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->incompleteCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }

    public function testSuccessCountWillNotIncludeRiskyTests()
    {
        $this->resultPrinter->testCount = 20;
        $this->resultPrinter->riskyCount = 10;
        $this->assert($this->resultPrinter->getSuccessCount(), exactly_equals, 10);
    }
}
