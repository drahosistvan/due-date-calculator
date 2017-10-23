<?php
use DueDateCalculator\Validation\SubmitDayValidator;
use DueDateCalculator\Exceptions\Validation\InvalidDateFormatException;
use DueDateCalculator\Exceptions\Validation\InvalidWorkdayDateException;

class SubmitDayValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_has_a_validate_method()
    {
        $validator = new SubmitDayValidator();
        $this->assertTrue(
            method_exists($validator, 'validate'),
            'Validate method not exists on validator'
        );
    }

    /** @test */
    public function it_checks_the_valid_date_format()
    {
        $this->expectException(InvalidDateFormatException::class);
        $validator = new SubmitDayValidator();
        $validator->validate('asda');
    }

    /** @test */
    public function it_checks_the_valid_weekday()
    {
        $this->expectException(InvalidWorkdayDateException::class);
        $validator = new SubmitDayValidator();
        $validator->validate('2017-10-22 10:00:00');
    }
}