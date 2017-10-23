<?php
use DueDateCalculator\Validation\TurnaroundTimeValidator;
use DueDateCalculator\Exceptions\Validation\InvalidTurnaroundTimeException;

class TurnaroundTimeValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_has_a_validate_method()
    {
        $validator = new TurnaroundTimeValidator();
        $this->assertTrue(
            method_exists($validator, 'validate'),
            'Validate method not exists on validator'
        );
    }

    /** @test */
    public function it_checks_that_turnaround_time_is_not_negative()
    {
        $this->expectException(InvalidTurnaroundTimeException::class);
        $validator = new TurnaroundTimeValidator();
        $validator->validate(-1);
    }
}