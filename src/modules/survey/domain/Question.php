<?php

namespace modules\survey\domain;

use modules\shared\domain\fields\Field;

final class Question extends Field
{
    public function __construct(int $order = null, string $content = null, Option $option = null)
    {
        parent::__construct( [
            'order' => $order ? new IntegerOrder( $order ) : IntegerOrder::none(),
            'content' => $content,
            'answer' => $option ?? Option::none()
        ] );
    }

    public function is_answered(): bool
    {
        return !empty($this['value']['answer']);
    }

    protected function ensure($input): array
    {
        $answer = $input['answer'];
        return [
            'order' => $input['order']['value'],
            'content' => $input['content'],
            'answer' => $answer->is_none() ? null : $answer['value']
        ];
    }
}