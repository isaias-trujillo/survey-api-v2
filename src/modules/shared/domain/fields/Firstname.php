<?php

namespace modules\shared\domain\fields;

final class Firstname extends SpanishName
{
    public function __construct(string $input = null)
    {
        parent::__construct( $input );
    }
}