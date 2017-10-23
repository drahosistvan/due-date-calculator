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

        $addedDays = floor($this->turnaroundHours / 8);
        $addedHours = $this->turnaroundHours % 8;

        $this->submitDay->addWeekdays($addedDays);

        if ( $leftHours = ($addedDays - (17 - $this->submitDay->hour)) <= 0) {
            $this->submitDay->addHours($addedHours);
        } else {
            $this->submitDay->addWeekday()->hour = 9;
            $this->submitDay->addHours($leftHours);
        }

        return $this->submitDay->format('Y-m-d H:i:s');
    }


}