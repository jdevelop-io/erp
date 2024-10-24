<?php

declare(strict_types=1);

namespace JDevelop\Erp\Test\Unit;

use JDevelop\Erp\Calculator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Calculator::class)]
final class CalculatorTest extends TestCase
{
    public function testAdd1Plus2Equals3(): void
    {
        $calculator = new Calculator();
        $result = $calculator->add(1, 2);
        $this->assertEquals(3, $result);
    }
}
