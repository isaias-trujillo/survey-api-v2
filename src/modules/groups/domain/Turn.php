<?php

namespace modules\groups\domain;

use Error;
use modules\shared\domain\fields\Field;

final class Turn extends Field
{
    private static $EMPTY;

    public function __construct(string $input)
    {
        parent::__construct( $input );
    }

    public static function empty(): Turn
    {
        if (!self::$EMPTY) {
            self::$EMPTY = new Turn( null );
        }
        return self::$EMPTY;
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
        // remove multiples whitespace
        $text = preg_replace( "/\s+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text ) || mb_strtolower($text) == "none") {
            return null;
        }
        $text = mb_strtoupper( strpos( $text, "-" ) ? $text : "-$text" );
        $pattern = "/-[MTN]/";
        if (!preg_match( $pattern, $text, $matches )) {
            return null;
        }
        $bound = count( $matches );
        $match = $matches[ $bound - 1 ];
        $match = trim( $match );

        if (!preg_match( $pattern, $match )) {
            return $input;
        }

        return ltrim( $match, "-" );
    }

    public static function subtract(string $value)
    {
        $instance = new Classroom( $value );
        if ($instance->error()) {
            return $value;
        }
        $pattern = "/-[MTN]/";
        return !( $subtracted = preg_replace( $pattern, "", $value ) ) ? $value : $subtracted;
    }
}