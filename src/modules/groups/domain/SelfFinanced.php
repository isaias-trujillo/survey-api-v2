<?php

namespace modules\groups\domain;

use modules\shared\domain\fields\Field;

class SelfFinanced extends Field
{
    public function __construct($input)
    {
        parent::__construct( $input );
    }

    protected function ensure($input): bool
    {
        if (is_bool( $input )) {
            return $input;
        }
        if (!$input or empty( $input )) {
            return false;
        }
        // remove multiples whitespace
        $text = preg_replace( "/\s+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text )) {
            return false;
        }
        $pattern = "/(\([a-zA-ZáéíóúÁÉÍÓÚ'\s]+\))+/";
        if (!preg_match_all( $pattern, $text )) {
            return false;
        }
        return true;
    }

    public static function subtract(string $value)
    {
        $instance = new SelfFinanced( $value );
        if ($instance->error()) {
            return $value;
        }
        $pattern = "/(\([a-zA-ZáéíóúÁÉÍÓÚ'\s]+\))+/";
        if (( !$subtracted = preg_replace( $pattern, "", $value ) )) {
            return $value;
        }
        return $subtracted;
    }
}