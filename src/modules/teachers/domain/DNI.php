<?php

namespace modules\teachers\domain;

use modules\shared\domain\fields\Field;
use modules\shared\domain\fields\InvalidArgumentError;

final class DNI extends Field
{
    public function __construct(string $input = null)

    {
        parent::__construct( $input );
    }

    protected function ensure($input): string
    {
        if (!$input or empty( $input )) {
            throw new InvalidArgumentError( "El DNI está vacío." );
        }
        // remove whitespaces
        $text = preg_replace( "/\s+/", '', $input );
        $text = trim( $text );
        if (empty( $text )) {
            throw new InvalidArgumentError( "El DNI está vacío." );
        }
        if (preg_match_all( "/\D+/", $text )) {
            throw new InvalidArgumentError( "El DNI ('$text') solo debe ser numérico." );
        }
        if (strlen( $text ) !== 8) {
            throw new InvalidArgumentError( "El DNI debe tener 8 dígitos." );
        }
        return $text;
    }
}