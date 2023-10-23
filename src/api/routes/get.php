<?php

use modules\groups\domain\Group;
use modules\teachers\domain\Teacher;

$tests = [
    "  ",
    "AUDITORIA INTERNA",
    "(AF) AUDITORIA INTERNA",
    "410 MATEMÁTICA FINANCIERA",
    "(AF)(ACJC) 410 MATEMÁTICA FINANCIERA",
    "(A  F   ) ( A CJ  C) 410 MATEMÁTICA FINANCIERA",
    "401-T CONTABILIDAD DE COSTOS I",
    "(AF)(APJC) 401-N CONTABILIDAD DE COSTOS I",
    "(AF)          (APJC)   401-N CONTABILIDAD DE COSTOS I\n\n",
    "102-M DERECHO TRIBUTARIO II",
    "400 D-T TRIBUTOS I",
    "Lab-A-M AUDITORÍA FINANCIERA I",
    "Lab-A-N FILOsoFÍa ",
];

$results = [];
$teacher = new Teacher( "Terrones", "Castle" );

foreach ($tests as $test) {
    $results[ $test ] = Group::raw( $test, $teacher );
}

echo json_encode( [
    'message' => 'Bienvenido a la API de Pregrado.',
    'results' => $results
] );