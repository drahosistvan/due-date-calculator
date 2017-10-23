<?php
namespace DueDateCalculator;

use Carbon\Carbon;
use DueDateCalculator\Exceptions\Validation\InvalidDateFormatException;
use DueDateCalculator\Exceptions\Validation\InvalidTurnaroundTimeException;
use DueDateCalculator\Exceptions\Validation\InvalidWorkdayDateException;

class DueDateCalculator
{
    private $submitDay;
    private $turnaroundHours;

    public function calculate($submitDay, $turnaroundHours)
    {
        try {
            $this->submitDay = Carbon::createFromFormat('Y-m-d H:i:s', $submitDay);
        } catch (\Exception $e) {
            throw new InvalidDateFormatException('Submit date has not valid format');
        }
        if ($this->submitDay->isWeekend()) {
            throw new InvalidWorkdayDateException('Submit day is in weekend');
        }
        if ( !($this->submitDay->hour >= 9 && $this->submitDay->hour < 17) ) {
            throw new InvalidWorkdayDateException('Submit day is out of working hours');
        }
        $this->turnaroundHours = $turnaroundHours;
        if ($this->turnaroundHours < 0) {
            throw new InvalidTurnaroundTimeException('Turnaround time is less than 0');
        }



        return '';
    }
}