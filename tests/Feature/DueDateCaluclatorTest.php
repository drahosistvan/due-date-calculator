<?php

use DueDateCalculator\DueDateCalculator;

class DueDateCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
	public function calculator_has_calculate_method()
    {
        $calculator = new DueDateCalculator();
        $this->assertTrue(
            method_exists($calculator, 'calculate'),
            'Calculate method not exists on calculator'
        );
    }
}