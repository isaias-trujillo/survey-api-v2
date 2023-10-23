<?php

namespace modules\teachers\infrastructure\criteria;

use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class FilterByDNI
{

    public static function of(string $dni): Criteria
    {
        return Criteria::builder()->filter(
            Filter::of( 'contrasena', '=', $dni )
        )->build();
    }
}