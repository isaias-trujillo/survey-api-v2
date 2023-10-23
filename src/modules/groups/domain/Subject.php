<?php

namespace modules\groups\domain;

use modules\shared\domain\fields\Field;
use modules\shared\domain\fields\InvalidArgumentError;

final class Subject extends Field
{
    private static $UPPER_CASE_WORDS = [
        "I", "II", "III", "IV", "V",
        "NIC", "NIF"
    ];

    public function __construct(string $input = null)

    {
        parent::__construct( $input );
    }

    protected function ensure($input): string
    {
        if (!$input or empty( $input )) {
            throw new InvalidArgumentError( "Curso sin nombre." );
        }
        // remove whitespaces
        $text = preg_replace( "/[\s\r\n]+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text )) {
            throw new InvalidArgumentError( "Curso sin nombre." );
        }
        if (strlen( $text ) < 4) {
            throw new InvalidArgumentError( "El curso debe tener al menos 4 caracteres." );
        }

        $pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚ'\s]+/";
        if (!preg_match_all( $pattern, $text )) {
            throw new InvalidArgumentError( "Curso solo debe tener caracteres alfabéticos." );
        }

        if (!( $fragments = explode( " ", $text ) )) {
            return ucwords( mb_strtolower( $text ) );
        }

        foreach ($fragments as &$fragment) {
            if (strlen( $fragment ) > 5) {
                $fragment = ucwords( mb_strtolower( $fragment ) );
                continue;
            }
            if (in_array( $fragment, Subject::$UPPER_CASE_WORDS )) {
                $fragment = mb_strtoupper( $fragment );
                continue;
            }
            $fragment = mb_strtolower( $fragment );

        }
        return implode( " ", $fragments );
    }
}