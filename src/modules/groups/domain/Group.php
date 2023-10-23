<?php

namespace modules\groups\domain;

use modules\shared\domain\Entity;
use modules\teachers\domain\Teacher;

final class Group extends Entity
{
    public function __construct(string $classroom, string $turn, string $subject, Teacher $teacher, $self_financed = false)
    {
        parent::__construct( [
            'classroom' => new Classroom( $classroom ),
            'turn' => new Turn( $turn ),
            'subject' => new Subject( $subject ),
            'self financed' => new SelfFinanced( $self_financed ),
            'teacher' => $teacher,
        ] );
    }

    public static function raw(string $name, Teacher $teacher): Group
    {
        $classroom = SelfFinanced::subtract($name);
        $turn = SelfFinanced::subtract($name);
        $course = Turn::subtract(Classroom::subtract(SelfFinanced::subtract($name)));

        return new Group(
            $classroom,
            $turn,
            $course,
            $teacher,
            $name
        );
    }
}