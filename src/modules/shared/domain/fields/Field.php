<?php

namespace modules\shared\domain\fields;

use ArrayObject;
use Error;

abstract class Field extends ArrayObject
{
    protected $error = null;

    public function __construct($input = null)
    {
        try {
            parent::__construct( [ 'value' => $this->ensure( $input ) ] );
        } catch (Error $error) {
            $this->error = $error->getMessage();
            parent::__construct();
        }
    }

    protected abstract function ensure($input);

    public function valid(): bool
    {
        return empty( $this->error() );
    }

    public function error()
    {
        return $this->error;
    }

    public function offsetSet($key, $value) {}

    public function offsetUnset($key) {}
}