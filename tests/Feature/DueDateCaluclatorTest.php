<?php

use DueDateCalculator\DueDateCalculator;
use DueDateCalculator\Exceptions\Validation\InvalidDateFormatException;
use DueDateCalculator\Exceptions\Validation\InvalidWorkdayDateException;
use DueDateCalculator\Exceptions\Validation\InvalidTurnaroundTimeException;

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

    /** @test */
    public function calculator_exept_parameters()
    {
        $this->expectException(ArgumentCountError::class);
        (new DueDateCalculator())->calculate(1);
    }

    /** @test */
    public function calculator_exept_valid_submit_date()
    {
        $this->expectException(InvalidDateFormatException::class);
        (new DueDateCalculator())->calculate('asd', 1);
    }

    /** @test */
    public function calculator_exept_valid_weekday()
    {
        $this->expectException(InvalidWorkdayDateException::class);
        (new DueDateCalculator())->calculate('2017-10-22 10:00:00', 1);
    }

    /** @test */
    public function calculator_exept_workday_time()
    {
        $this->expectException(InvalidWorkdayDateException::class);
        (new DueDateCalculator())->calculate('2017-10-23 18:00:00', 1);
    }

    /** @test */
    public function calculator_exept_valid_turnaround_days()
    {
        $this->expectException(InvalidTurnaroundTimeException::class);
        (new DueDateCalculator())->calculate('2017-10-23 15:00:00', -1);
    }

    /** @test */
    public function calculator_can_calculate_with_days()
    {
        $this->assertEquals(
            '2017-10-30 15:00:00',
            (new DueDateCalculator())->calculate('2017-10-27 15:00:00', 8)
        );

        $this->assertEquals(
            '2017-10-31 15:00:00',
            (new DueDateCalculator())->calculate('2017-10-27 15:00:00', 16)
        );

        $this->assertEquals(
            '2017-11-01 15:00:00',
            (new DueDateCalculator())->calculate('2017-10-30 15:00:00', 16)
        );
    }
}