<?php

use api\core\Request;
use modules\shared\domain\criteria\Criteria;
use modules\students\infrastructure\filter\FilterStudentByCode;
use modules\students\infrastructure\StudentService;

$parameters = Request::parameters();

if (!( $code = $parameters['code'] ?? null )) {
    echo json_encode( [ 'error' => 'No se proporcionó un código de estudiante' ] );
    exit();
}

$filter = FilterStudentByCode::of( $code );
$criteria = Criteria::builder()->filter( $filter )->build();

$service = new StudentService();
$response = $service->match( $criteria );

echo json_encode( $response );