<?php

namespace modules\shared\domain;

use ArrayObject;
use modules\shared\domain\fields\Field;

abstract class Entity extends ArrayObject
{
    private $errors;

    public function __construct(array $properties)
    {
        $data = $this->mapping( $properties );
        $this->errors = $data['errors'];
        parent::__construct( $data['values'] ?? [] );
    }

    private function mapping(array $properties): array
    {
        $data = [ 'values' => null, 'errors' => null ];
        foreach ($properties as $name => $property) {
            if ($property instanceof Field) {
                if (!$property->valid()) {
                    $data['errors'][ $name ] = $property->error();
                    continue;
                }
                $data['values'][ $name ] = $property['value'];
                continue;
            }
            if ($property instanceof Entity) {
                if (!$property->valid()) {
                    $data['errors'][ $name ] = $property->errors();
                }
                $data['values'][ $name ] = $property;
                continue;
            }
            if (is_array( $property )) {
                $result = $this->mapping( $property );
                $data['values'][ $name ] = $result['values'];
                continue;
            }
            $data['values'][ $name ] = $property;
        }
        return $data;
    }

    public function valid(): bool
    {
        return empty( $this->errors() );
    }

    public function errors()
    {
        return $this->errors;
    }
}