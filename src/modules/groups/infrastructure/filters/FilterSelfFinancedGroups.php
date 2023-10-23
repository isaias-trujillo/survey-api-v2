<?php

namespace modules\groups\infrastructure\filters;

use modules\shared\domain\criteria\Filter;

final class FilterSelfFinancedGroups
{
    public static function of($self_financed = null): Filter
    {
        if (is_null( $self_financed )) {
            return Filter::of( 'Aula_Turno', 'like', '%%' );
        }

        if (!( filter_var($self_financed, FILTER_VALIDATE_BOOLEAN) )) {
            return Filter::of( 'Aula_Turno', 'not like', '(AF)%' );
        }
        return Filter::of( 'Aula_Turno', 'like', '(AF)%' );

    }
}