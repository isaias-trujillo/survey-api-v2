<?php

use api\core\Request;
use modules\teachers\domain\DNI;
use modules\teachers\infrastructure\TeacherService;

$parameters = Request::parameters();

$service = new TeacherService();
$response = $service->find( $parameters['dni'] ?? null );

echo json_encode( $response );