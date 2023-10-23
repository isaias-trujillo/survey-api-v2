<?php

namespace modules\groups\infrastructure\filters;

use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterNotNullGroups
{
    public static function of(): Filter
    {

        return Filter::of( "Aula_Turno", '<>', "NULL" );
    }
}