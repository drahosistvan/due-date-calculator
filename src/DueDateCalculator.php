<?php
namespace DueDateCalculator;

use DueDateCalculator\Models\Workday;
use DueDateCalculator\Validation\SubmitDayValidator;
use DueDateCalculator\Validation\TurnaroundTimeValidator;

class DueDateCalculator
{
    private $workday;
    private $turnaroundHours;

    public function calculate($submitDay, $turnaroundHours)
    {
        $this->workday = new Workday((new SubmitDayValidator)->validate($submitDay));
        $this->turnaroundHours = (new TurnaroundTimeValidator())->validate($turnaroundHours);

        $this->workday->addWorkingHours($this->turnaroundHours);

        return $this->workday->get('Y-m-d H:i:s');
    }
}