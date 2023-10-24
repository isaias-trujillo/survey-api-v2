<?php

namespace modules\survey\domain;

use Error;
use modules\groups\domain\Group;
use modules\shared\domain\fields\Field;

final class SurveyUnit extends Field implements Progressive
{
    public function __construct(Group $group, Question ...$questions)
    {
        parent::__construct( [
            'group' => $group,
            'questions' => $questions
        ] );
    }

    public static function from(array $data): SurveyUnit
    {
        return new SurveyUnit(
            $data['group'],
            ...array_map( function ($item) {
                return Question::from( $item );
            }, $data['questions'] )
        );
    }

    protected function ensure($input): array
    {
        if (!( $group = $input['group'] )->valid()) {
            throw new Error( $group->error() );
        }
        $questions = array_filter(
            array_map( function (Question $question) {
                if ($question->valid()) {
                    return $question['value'];
                }
                return null;
            }, $input['questions'] )
        );
        if (count( $questions ) < count( $input['questions'] )) {
            throw new Error( "Hay preguntas inválidas." );
        }
        return [ 'group' => $group, 'questions' => $questions ];
    }

    function progress(): array
    {
        $total = count( $this['value']['questions'] ?? [] );
        $answered_questions = array_reduce( $this['value']['questions'], function (int $count, array $data) {
            $question = Question::from($data);
            return $count + ( $question->is_answered() ? 1 : 0);
        }, 0 );
        return [
            'total' => $total,
            'completed' => $answered_questions,
            'missing' => $total - $answered_questions
        ];
    }

    function completed(): bool
    {
        $progress = $this->progress();
        return $progress['total'] === $progress['completed'];
    }
}