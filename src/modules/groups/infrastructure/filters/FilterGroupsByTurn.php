<?php

namespace modules\groups\infrastructure\filters;

use Error;
use modules\groups\domain\Classroom;
use modules\groups\domain\Turn;
use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterGroupsByTurn
{
    public static function of(string $turn = null): Filter
    {
        $property = new Turn( $turn );
        if (!$property->valid()) {
            throw new Error( $property->error() );
        }

        $search = $property['value'] ?? "";

        if (!$property->is_none()) {
            return Filter::of( "Aula_Turno", 'like', "%$search%" );
        }

        return Filter::of( "Aula_Turno", 'like', "%$search%" )
            ->and( Filter::of( "Aula_Turno", 'not like', '%-M%' ) )
            ->and( Filter::of( "Aula_Turno", 'not like', '%-T%' ) )
            ->and( Filter::of( "Aula_Turno", 'not like', '%-N%' ) );

    }
}