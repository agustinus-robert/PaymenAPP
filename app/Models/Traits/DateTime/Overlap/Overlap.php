<?php

namespace App\Models\Traits\DateTime\Overlap;

use Carbon\Carbon;

class Overlap
{
    /**
     * Define class constructor.
     */
    public function __construct(
        public Carbon $from,
        public Carbon $to,
        public ?Carbon $start,
        public ?Carbon $end
    ) {
    }

    public $default_diff_getter = 'diffInSeconds';

    /**
     * Get periodic difference with getter.
     */
    public function periodicDiffIn($getter = 'minutes')
    {
        $getter = 'diffIn' . ucfirst(strtolower($getter));

        return [
            'before' => '',
            'inside' => '',
            'after' => '',
        ];
    }

    /**
     * Get all passed conditions.
     */
    public function getAllConditions()
    {
        $passed = [];
        foreach ($this->handlePeriodConditions() as $key => $item) {
            if ($item['conditions']) {
                $passed[$key] = $item;
            }
        }
        return collect($passed);
    }

    /**
     * Handle all period conditions.
     */
    public function handlePeriodConditions()
    {
        $getter = $this->default_diff_getter;

        return is_null($this->start) && is_null($this->end)
            ? [
                'AllDay' => [
                    'conditions' => true,
                    'count' => [
                        'outside' => $this->from->{$getter}($this->to)
                    ]
                ]
            ] : [
                'BeforeAll' => [
                    'conditions' => $this->from->lt($this->start) && $this->to->lt($this->start),
                    'count' => [
                        'before' => $this->from->{$getter}($this->to)
                    ]
                ],
                'BeforeStart' => [
                    'conditions' => $this->from->lt($this->start) && $this->to->lte($this->start) && $this->to->eq($this->start),
                    'count' => [
                        'before' => $this->from->{$getter}($this->to)
                    ]
                ],
                'BeforeInside' => [
                    'conditions' => $this->from->lt($this->start) && $this->to->gt($this->start) && $this->to->lt($this->end),
                    'count' => [
                        'before' => $this->from->{$getter}($this->start),
                        'inside' => $this->start->{$getter}($this->to)
                    ]
                ],
                'BeforeEnd' => [
                    'conditions' => $this->from->lt($this->start) && $this->to->gt($this->start) && $this->to->lte($this->end) && $this->to->eq($this->end),
                    'count' => [
                        'before' => $this->from->{$getter}($this->start),
                        'inside' => $this->start->{$getter}($this->to)
                    ]
                ],
                'BeforeOverlap' => [
                    'conditions' => $this->from->lt($this->start) && $this->to->gt($this->start) && $this->to->gt($this->end),
                    'count' => [
                        'before' => $this->from->{$getter}($this->start),
                        'inside' => $this->start->{$getter}($this->end),
                        'after' => $this->to->{$getter}($this->end)
                    ]
                ],
                'StartInside' => [
                    'conditions' => $this->from->eq($this->start) && $this->from->gte($this->start) && $this->to->lt($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->to)
                    ]
                ],
                'StartEnd' => [
                    'conditions' => $this->from->eq($this->start) && $this->from->gte($this->start) && $this->to->lte($this->end) && $this->to->eq($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->to)
                    ]
                ],
                'StartOverlap' => [
                    'conditions' => $this->from->eq($this->start) && $this->from->gte($this->start) && $this->to->gt($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->end),
                        'after' => $this->end->{$getter}($this->to)
                    ]
                ],
                'Inside' => [
                    'conditions' => $this->from->gt($this->start) && $this->to->lt($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->to)
                    ]
                ],
                'InsideEnd' => [
                    'conditions' => $this->from->gt($this->start) && $this->to->lte($this->end) && $this->to->eq($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->to)
                    ]
                ],
                'InsideOverlap' => [
                    'conditions' => $this->from->gt($this->start) && $this->from->lt($this->end) && $this->to->gt($this->end),
                    'count' => [
                        'inside' => $this->from->{$getter}($this->end),
                        'after' => $this->end->{$getter}($this->to)
                    ]
                ],
                'AfterEnd' => [
                    'conditions' => $this->from->eq($this->end) && $this->from->gte($this->end) && $this->to->gt($this->end),
                    'count' => [
                        'after' => $this->from->{$getter}($this->to)
                    ]
                ],
                'AfterAll' => [
                    'conditions' => $this->from->gt($this->end) && $this->to->gt($this->end),
                    'count' => [
                        'after' => $this->from->{$getter}($this->to)
                    ]
                ],

            ];
    }
}
