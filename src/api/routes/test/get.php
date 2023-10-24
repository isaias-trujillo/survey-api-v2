<?php

use modules\groups\domain\Group;
use modules\shared\domain\criteria\Criteria;
use modules\students\infrastructure\filter\FilterStudentByCode;
use modules\students\infrastructure\StudentService;
use modules\survey\domain\Option;
use modules\survey\domain\Question;
use modules\survey\domain\Survey;
use modules\survey\domain\SurveyUnit;
use modules\teachers\domain\Teacher;

try {
    $option = new Option('2', 'Regular', '0.25');

    $question = new Question( 1, '¿Qué haces?', $option );

    $teacher = new Teacher( "VILCHEZ OLIVARES PERCY ANTONIO", "07712178" );
    $group = Group::raw( "312-M INTRODUCCIÓN A LA CONTABILIDAD", $teacher );

    $response = ( new StudentService() )->match( Criteria::builder()->filter( FilterStudentByCode::of( '11110270' ) )->build() );
    if ($student = isset( $response['error'] ) || isset( $response['erros'] ) ? null : $response) {
        $unit = new SurveyUnit( $group, ...[ $question, $question, $question, $question ] );

        if (!$unit->valid()) {
            echo json_encode( [ 'error' => $unit->error() ] );
            exit();
        }

        $survey = new Survey($student, [$option, $option, $option], ...[$unit, $unit, $unit]);

        if (!$survey->valid()) {
            echo json_encode( [ 'errors' => $survey->errors() ] );
            exit();
        }

        echo json_encode( $survey);
        exit();
    }

    echo json_encode( $response );
} catch (Error $error) {
    echo json_encode( [ 'error' => $error->getMessage() ] );
}
