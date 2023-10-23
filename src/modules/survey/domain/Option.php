<?php

namespace modules\survey\domain;

use modules\shared\domain\fields\Field;
use modules\shared\domain\fields\InvalidArgumentError;

class Option extends Field
{
    private static $NONE;

    public function __construct(int $order = null, string $name = null, string $value = null)
    {
        parent::__construct( [
            'order' => $order ? new IntegerOrder( $order ) : IntegerOrder::none(),
            'name' => new OptionName($name),
            'score' => $value
        ] );
    }

    public static function none(): Option
    {
        if (!Option::$NONE) {
            Option::$NONE = new Option(null, 'none', null);
        }
        return Option::$NONE;
    }

    public function is_none(): bool
    {
        return $this['value']['order'] == null;
    }

    protected function ensure($input): array
    {
        return [
            'order' => $input['order']['value'],
            'name' => $input['name']['value'],
            'score' => $input['score'],
        ];
    }
}