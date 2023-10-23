<?php

namespace modules\groups\domain;

use modules\shared\domain\fields\Field;

final class Faculty extends Field
{
    public function __construct(string $input, string $name)
    {
        parent::__construct( [
            'code' => $input,
            'name' => $name
        ] );
    }

    protected function ensure($input): string
    {
        return $input;
    }
}