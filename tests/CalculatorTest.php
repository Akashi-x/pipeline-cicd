<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Calculator.php';

#[\PHPUnit\Framework\Attributes\CoversClass(\Calculator::class)]
class CalculatorTest extends TestCase {

    private $calculator;

    protected function setUp(): void {
        $this->calculator = new Calculator();
    }

    public function testAdd() {
        $this->assertEquals(5, $this->calculator->add(2, 3));
    }

    public function testSubtract() {
        $this->assertEquals(1, $this->calculator->subtract(3, 2));
    }

    public function testMultiply() {
        $this->assertEquals(6, $this->calculator->multiply(2, 3));
    }

    public function testDivide() {
        $this->assertEquals(2, $this->calculator->divide(6, 3));
    }

    public function testDivideByZero() {
        $this->expectException(Exception::class);
        $this->calculator->divide(6, 0);
    }
}
