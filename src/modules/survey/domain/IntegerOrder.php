<?php

namespace modules\survey\domain;

use modules\shared\domain\fields\Field;
use modules\shared\domain\fields\InvalidArgumentError;

final class IntegerOrder extends Field
{
    private static $NONE;

    public static function none(): IntegerOrder
    {
        if (!IntegerOrder::$NONE) {
            IntegerOrder::$NONE = new IntegerOrder( null );
        }
        return IntegerOrder::$NONE;
    }

    public function is_none(): bool
    {
        return $this['value'] == null;
    }

    protected function ensure($input)
    {
        if (empty( $input )) {
            return null;
        }

        if (!is_int( $input ) && !is_string( $input )) {
            return null;
        }

        if (is_int( $input )) {
            $parsed_value = intval( $input );
            if ($parsed_value <= 0) {
                return null;
            }
            return $parsed_value;
        }
        // replace multiples whitespaces by single white space
        $text = preg_replace( "/\s+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text )) {
            return null;
        }
        if (preg_match( "/\D+/", $text )) {
            throw new InvalidArgumentError("El orden debe ser numérico.");
        }
        return intval($text);
    }
}