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

    public static function from(array $data): Question
    {
        $option = $data['answer'] instanceof Option ? $data['answer'] : Option::from( $data['answer'] );
        return new Question(
            $data['order'],
            $data['content'],
            $option
        );
    }

    public function is_answered(): bool
    {
        return !is_null( $this['value']['answer'] );
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