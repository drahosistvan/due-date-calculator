<?php
namespace DueDateCalculator;

use DueDateCalculator\Validation\SubmitDayValidator;
use DueDateCalculator\Validation\TurnaroundTimeValidator;

class DueDateCalculator
{
    private $workday;
    private $turnaroundHours;

    public function calculate($submitDay, $turnaroundHours)
    {
        $this->workday = (new SubmitDayValidator)->validate($submitDay);
        $this->turnaroundHours = (new TurnaroundTimeValidator())->validate($turnaroundHours);


        $addedDays = floor($this->turnaroundHours / 8);
        $addedHours = $this->turnaroundHours % 8;

        $this->workday->addWeekdays($addedDays);

        if ( $leftHours = ($addedDays - (17 - $this->workday->hour)) <= 0) {
            $this->workday->addHours($addedHours);
        } else {
            $this->workday->addWeekday()->hour = 9;
            $this->workday->addHours($leftHours);
        }

        return $this->workday->format('Y-m-d H:i:s');
    }
}