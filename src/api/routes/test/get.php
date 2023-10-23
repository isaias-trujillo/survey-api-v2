<?php

use modules\survey\domain\Option;
use modules\survey\domain\Question;

$option = new Option( 1, "Deficiente", '0.25' );
$question = new Question( 1, '¿Qué haces?', $option );
$response = $question->valid() ? $question : [ 'error' => $question->error() ];

echo json_encode( $response );