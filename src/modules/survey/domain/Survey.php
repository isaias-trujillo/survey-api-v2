<?php

namespace modules\survey\domain;

use modules\shared\domain\Entity;
use modules\students\domain\Student;

final class Survey extends Entity implements Progressive
{
    public function __construct(Student $student, array $options, SurveyUnit ...$units)
    {
        parent::__construct( [
            'student' => $student,
            'options' => $options,
            'units' => $units
        ] );
    }

    public function is_empty(): bool
    {
        return empty( $this['options'] );
    }

    function progress(): array
    {
        if ($this->is_empty()) {
            return [ 'total' => 0, 'completed' => 0, 'missing' => 0 ];
        }
        $total = count( $this['units'] );
        $answered_units = array_reduce( $this['units'], function (int $count, SurveyUnit $unit) {
            return $count + $unit->completed() ? 1 : 0;
        } );
        return [
            'total' => $total,
            'completed' => $answered_units,
            'missing' => $total - $answered_units
        ];
    }

    function completed(): bool
    {
        $progress = $this->progress();
        return $progress['total'] == $progress['completed'];
    }
}