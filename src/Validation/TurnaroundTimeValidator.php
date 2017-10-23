<?php
namespace DueDateCalculator\Validation;

use DueDateCalculator\Contracts\Validation\Validator;
use DueDateCalculator\Exceptions\Validation\InvalidTurnaroundTimeException;

class TurnaroundTimeValidator implements Validator
{
    public function validate($turnaroundHours) {
        if ($turnaroundHours < 0) {
            throw new InvalidTurnaroundTimeException('Turnaround time is less than 0');
        }

        return $turnaroundHours;
    }
}