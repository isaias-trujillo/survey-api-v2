<?php

namespace modules\shared\domain\fields;

abstract class SpanishName extends Field
{
    public function __construct(string $input = null)
    {
        parent::__construct( $input );
    }

    protected function ensure($input): string
    {
        if (empty( $input )) {
            throw new InvalidArgumentError("Vacío.");
        }
        // replace multiples whitespaces by single white space
        $text = preg_replace( "/\s+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text )) {
            throw new InvalidArgumentError("Vacío.");
        }
        if (preg_match_all( "/[^a-zA-ZñÑáéíóúÁÉÍÓÚüÜ'¿?\s]+/", $text )) {
            throw new InvalidArgumentError("Solo debe contener caracteres alfabéticos ('$text').");
        }
        return ucwords(mb_strtolower($text));
    }
}