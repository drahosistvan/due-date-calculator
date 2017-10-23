<?php

namespace DueDateCalculator\Validation;

use Carbon\Carbon;
use DueDateCalculator\Contracts\Validation\Validator;
use DueDateCalculator\Exceptions\Validation\InvalidDateFormatException;
use DueDateCalculator\Exceptions\Validation\InvalidWorkdayDateException;

class SubmitDayValidator implements Validator
{
    private $date;

    public function validate($submitDay)
    {
        $this->createDateFormat($submitDay)
              ->validateWeekday()
              ->validateWorkHours();

        return $this->date;
    }

    private function createDateFormat($submitDay){
        try {
            $this->date = Carbon::createFromFormat('Y-m-d H:i:s', $submitDay);
            return $this;
        } catch (\Exception $e) {
            throw new InvalidDateFormatException('Submit date has not valid format');
        }
    }

    private function validateWeekday(){
        if ($this->date->isWeekend()) {
            throw new InvalidWorkdayDateException('Submit day is in weekend');
        }

        return $this;
    }

    private function validateWorkHours() {
        if (!($this->date->hour >= 9 && $this->date->hour < 17)) {
            throw new InvalidWorkdayDateException('Submit day is out of working hours');
        }

        return $this;
    }
}