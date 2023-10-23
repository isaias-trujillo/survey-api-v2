<?php

namespace modules\students\domain;

use modules\shared\domain\fields\Field;
use modules\shared\domain\fields\InvalidArgumentError;

final class StudentEmail extends Field
{
    private static $VALID_DOMAINS = [
        "unmsm.edu.pe"
    ];

    public function __construct(string $input = null)

    {
        parent::__construct( $input );
    }

    protected function ensure($input): string
    {
        if (empty( $input )) {
            throw new InvalidArgumentError( "El correo del estudiante está vacío." );
        }
        // remove whitespaces
        $text = preg_replace( "/\s+/", '', $input );
        $text = trim( $text );


        $has_invalid_domain = true;

        foreach (StudentEmail::$VALID_DOMAINS as $domain) {
            $pattern = "/\w+(.\w+)?@$domain/";
            if (preg_match( $pattern, $text )) {
                $has_invalid_domain = false;
                break;
            }
            echo $pattern;
        }

        if ($has_invalid_domain) {
            throw new InvalidArgumentError( "El correo del estudiante no tiene un domino válido." );
        }
        return $text;
    }
}
