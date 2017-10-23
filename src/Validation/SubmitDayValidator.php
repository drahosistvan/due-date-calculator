<?php

namespace DueDateCalculator\Validation;

use Carbon\Carbon;
use DueDateCalculator\Contracts\Validation\Validator;
use DueDateCalculator\Exceptions\Validation\InvalidDateFormatException;
use DueDateCalculator\Exceptions\Validation\InvalidWorkdayDateException;

class SubmitDayValidator implements Validator
{
    public function validate($submitDay)
    {
        try {
            $validatedDay = Carbon::createFromFormat('Y-m-d H:i:s', $submitDay);
        } catch (\Exception $e) {
            throw new InvalidDateFormatException('Submit date has not valid format');
        }

        if ($validatedDay->isWeekend()) {
            throw new InvalidWorkdayDateException('Submit day is in weekend');
        }

        if (!($validatedDay->hour >= 9 && $validatedDay->hour < 17)) {
            throw new InvalidWorkdayDateException('Submit day is out of working hours');
        }

        return $validatedDay;
    }
}