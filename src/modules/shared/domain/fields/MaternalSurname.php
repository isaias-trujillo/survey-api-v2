<?php

namespace modules\shared\domain\fields;

final class MaternalSurname extends SpanishName
{
    public function __construct(string $input = null)
    {
        parent::__construct( $input );
    }
}