<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Unit;

use JDevelop\Erp\Calculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    /**
     * @return iterable<string, iterable<int>>
     */
    public static function additionDataProvider(): iterable
    {
        return [
            'one plus two' => [1, 2, 3],
            'two plus three' => [2, 3, 5],
            'three plus four' => [3, 4, 7],
            'four plus five' => [4, 5, 9],
            'five plus eleven' => [5, 11, 16],
        ];
    }

    #[DataProvider('additionDataProvider')]
    public function testAdd(int $a, int $b, int $expected): void
    {
        $calculator = new Calculator();
        $result = $calculator->add($a, $b);
        $this->assertSame($expected, $result);
    }
}
