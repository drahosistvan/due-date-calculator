<?php

namespace DueDateCalculator\Models;

use Carbon\Carbon;

class Workday
{
    const WORK_START = 9;
    const WORK_END = 17;

    private $workday;
    private $hoursPerDay;

    public function __construct(Carbon $workday)
    {
        $this->workday = $workday;
        $this->hoursPerDay = $this::WORK_END - $this::WORK_START;
    }

    public function addWorkingHours($workingHours)
    {
        /* First we add full workdays */
        $this->addDays(floor($workingHours / $this->hoursPerDay));
        /* Then we add the rest hours */
        $this->addHours($workingHours % $this->hoursPerDay);
    }

    public function get()
    {
        return $this->workday->format('Y-m-d H:i:s');
    }

    private function addDays($numberOfDays)
    {
        $this->workday->addWeekdays($numberOfDays);
    }

    private function addHours($numberOfHours)
    {
        $leftHours = $this->calculateLeftHours($numberOfHours);

        if ($leftHours <= 0) {
            $this->workday->addHours($numberOfHours);
            return true;
        }

        $this->workday->addWeekday()->hour = $this::WORK_START;
        $this->workday->addHours($leftHours);
    }

    private function calculateLeftHours($numberOfHours)
    {
        return $numberOfHours - ($this::WORK_END - $this->workday->hour);
    }
}