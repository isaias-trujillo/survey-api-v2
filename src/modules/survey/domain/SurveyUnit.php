<?php

namespace modules\survey\domain;

use Error;
use modules\groups\domain\Group;
use modules\shared\domain\fields\Field;

final class SurveyUnit extends Field implements Progressive
{
    public function __construct(Group $group, Question ...$question)
    {
        parent::__construct( [
            'group' => $group,
            'questions' => $question
        ] );
    }

    protected function ensure($input): array
    {
        if (!( $group = $input['group'] )->valid()) {
            throw new Error( $group->error() );
        }
        $questions = array_filter(
            array_filter( $input['questions'], function (Question $question) {
                if ($question->valid()) {
                    return $question;
                }
                return null;
            } )
        );
        if (count( $questions ) < count( $input['questions'] )) {
            throw new Error( "Hay preguntas inválidas." );
        }
        return [ 'group' => $group, 'questions' => $questions ];
    }

    function progress(): array
    {
        $total = count( $this['questions'] );
        $answered_questions = array_reduce( $this['questions'], function (int $count, Question $question) {
            return $count + $question->is_answered() ? 1 : 0;
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
        return $progress['total'] == $progress['completed'];
    }
}