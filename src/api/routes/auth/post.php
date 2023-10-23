<?php

use api\core\Request;
use modules\auth\domain\User;
use modules\auth\infrastructure\AuthService;
use modules\teachers\domain\DNI;
use modules\teachers\infrastructure\TeacherService;

if (!( $body = Request::body() )) {
    echo json_encode( [
        'error' => 'No se proporcionó ninguna información.'
    ] );
    exit();
}

$service = new AuthService();
$response = $service->authenticate( $body['username'] ?? "", $body['password'] ?? "" );
echo json_encode( $response );