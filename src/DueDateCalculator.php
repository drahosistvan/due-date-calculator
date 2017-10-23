<?php
namespace DueDateCalculator;

use DueDateCalculator\Validation\SubmitDayValidator;
use DueDateCalculator\Validation\TurnaroundTimeValidator;

class DueDateCalculator
{
    private $submitDay;
    private $turnaroundHours;

    public function calculate($submitDay, $turnaroundHours)
    {
        $this->submitDay = (new SubmitDayValidator)->validate($submitDay);
        $this->turnaroundHours = (new TurnaroundTimeValidator())->validate($turnaroundHours);


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