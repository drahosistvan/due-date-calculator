<?php

namespace DueDateCalculator\Models;

use Carbon\Carbon;

class Workday
{
    private $workday;


    public function __construct(Carbon $workday)
    {
        $this->workday = $workday;
    }

    public function addWorkingHours($workingHours)
    {
        $addedDays = floor($workingHours / 8);
        $addedHours = $workingHours % 8;

        $this->addDays($addedDays);
        $this->addHours($addedHours);
    }

    private function addDays($numberOfDays)
    {
        $this->workday->addWeekdays($numberOfDays);
    }

    private function addHours($numberOfHours)
    {
        if ($leftHours = ($numberOfHours - (17 - $this->workday->hour)) <= 0) {
            $this->workday->addHours($numberOfHours);
        } else {
            $this->workday->addWeekday()->hour = 9;
            $this->workday->addHours($leftHours);
        }
    }

    public function get()
    {
        return $this->workday->format('Y-m-d H:i:s');
    }
}