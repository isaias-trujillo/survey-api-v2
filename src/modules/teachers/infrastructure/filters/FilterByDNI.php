<?php

namespace modules\teachers\infrastructure\filters;

use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterByDNI
{

    public static function of(string $dni): Filter
    {
        return Filter::of( 'contrasena', '=', $dni );
    }
}