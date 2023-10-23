<?php

namespace modules\groups\domain;

use modules\shared\domain\fields\Field;

final class Classroom extends Field
{
    private static $EMPTY;

    public function __construct(string $input)
    {
        parent::__construct( $input );
    }

    public static function empty(): Classroom
    {
        if (!self::$EMPTY) {
            self::$EMPTY = new Classroom( null );
        }
        return self::$EMPTY;
    }

    public function is_none(): bool
    {
        return $this['value'] == null;
    }

    protected function ensure($input)
    {
        if (!$input or empty( $input )) {
            return null;
        }
        // remove multiples whitespace
        $text = preg_replace( "/\s+/", ' ', $input );
        $text = trim( $text );
        if (empty( $text ) || mb_strtolower($text) == "none") {
            return null;
        }
        if (!( $fragments = explode( " ", $text ) ) || empty( $fragments )) {
            return null;
        }
        $pattern = "/((\d{3}(\s[ABCD]$)?)|(Lab-[AB]))(-[MTN])?/";
        if (!preg_match( $pattern, $text, $matches )) {
            return null;
        }
        return trim($matches[1]);
    }

    public static function subtract(string $value): string
    {
        $instance = new Classroom( $value );
        if ($instance->error()) {
            return $value;
        }
        $pattern = "/((\d{3}(\s[ABCD]$)?)|(Lab-[AB]))(-[MTN])?/";
        return !( $subtracted = preg_replace( $pattern, "", $value ) ) ? trim($value) : trim($subtracted);
    }
}