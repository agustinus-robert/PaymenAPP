<?php

namespace App\Models\Traits\DateTime\Overlap;

use Carbon\Carbon;
use App\Models\Traits\DateTime\Overlap\Overlap;

trait Overlapable
{
    /**
     * Handle all period conditions.
     */
    public function getAllOverlapConditions($start, $end)
    {
        $period = new Overlap($this->getFrom(), $this->getTo(), $start, $end);

        return $period->getAllConditions();
    }

    /**
     * Calculate range.
     */
    public function calculateRange()
    {
        $groups = [];
        $period = $this->getFrom()->copy()->startOfDay()->toPeriod($this->getTo());

        foreach ($period as $date) {

            $start = $date->dayOfWeekIso <= 5 ? $date->copy()->setTimeFrom('08:00:00') : null;
            $end = $date->dayOfWeekIso <= 5 ? $date->copy()->setTimeFrom('16:00:00') : null;

            $date_from = $this->getFrom()->copy()->setDateFrom($date);
            $date_to = $this->getTo()->copy()->setDateFrom($date);

            if (!$this->getFrom()->isSameDay($this->getTo())) {
                if (!$date_from->isSameDay($this->getTo())) {
                    $date_to = $date_to->endOfDay();
                }

                if ($date_from->gt($this->getFrom())) {
                    $date_from = $date_from->startOfDay();
                }
            }

            $overlap = new Overlap($date_from, $date_to, $start, $end);
            $overlap->default_diff_getter = 'floatDiffInHours';

            $groups[] = $overlap->getAllConditions()->toArray();
        }

        return $groups;
    }

    /**
     * Get from attribute.
     */
    public function getFrom()
    {
        return $this->{$this->overlapable_period[0]}
            ? Carbon::parse($this->{$this->overlapable_period[0]})
            : now();
    }

    /**
     * Get to attribute.
     */
    public function getTo()
    {
        return $this->{$this->overlapable_period[1]}
            ? Carbon::parse($this->{$this->overlapable_period[1]})
            : now();
    }
}
