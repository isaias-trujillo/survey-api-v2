<?php

namespace modules\shared\domain\fields;

final class FullName extends SpanishName
{
    public function __construct(string $input = null)
    {
        parent::__construct( $input );
    }
}