<?php
namespace DueDateCalculator;


class DueDateCalculator
{
    private $day;
    private $turnaroundHours;

    public function calculate($day, $turnaroundHours)
    {
        $this->day = $day;
        $this->turnaroundHours = $turnaroundHours;
    }
}