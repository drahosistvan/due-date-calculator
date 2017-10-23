<?php
use DueDateCalculator\Validation\SubmitDayValidator;

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
}