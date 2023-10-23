<?php

use api\core\Request;
use modules\groups\infrastructure\filters\FilterGroupsByClassroom;
use modules\groups\infrastructure\filters\FilterGroupsBySubject;
use modules\groups\infrastructure\filters\FilterGroupsByTurn;
use modules\groups\infrastructure\filters\FilterSelfFinancedGroups;
use modules\groups\infrastructure\filters\FilterNotNullGroups;
use modules\groups\infrastructure\filters\FilterGroupsByStudentCode;
use modules\groups\infrastructure\GroupService;
use modules\shared\domain\criteria\Criteria;

$request = new Request();

$filter = FilterNotNullGroups::of();
$criteria = Criteria::builder();

if (empty( $query = $request['query'] )) {
    $criteria->filter( $filter )
        ->limit( 10 )
        ->offset( 0 );
    run( $criteria->build() );
    exit();
}

$limit = $query['limit'] ?? $query['perPage'] ?? 10;
$offset = intval( ( $query['page'] ?? 1 ) * $limit - $limit );

if ($classroom = $query['classroom'] ?? null) {
    $other_filter = FilterGroupsByClassroom::of( $classroom );
    $filter = $filter->and( $other_filter );
}

if ($turn = $query['turn'] ?? null) {
    $other_filter = FilterGroupsByTurn::of( $turn );
    $filter = $filter->and( $other_filter );
}

if ($subject = $query['subject'] ?? null) {
    $other_filter = FilterGroupsBySubject::of( $subject );
    $filter = $filter->and( $other_filter );
}

if ($self_financed = $query['selfFinanced'] ?? null) {
    $other_filter = FilterSelfFinancedGroups::of( $self_financed );
    $filter = $filter->and( $other_filter );
}

if (!( $student_code = $query['studentCode'] ?? null )) {
    $criteria->filter( $filter )->limit( $limit )->offset( $offset );

    run( $criteria->build() );
    exit();
}

$other_filter = FilterGroupsByStudentCode::of( $student_code );
$filter = $filter->and( $other_filter );

$criteria->filter( $filter );

if (isset( $query['page'] ) && intval( $query['page'] ) > 0) {
    $criteria->limit( $limit )->offset( $offset );
}
run( $criteria->build() );
exit();


function run(Criteria $criteria)
{
    $service = new GroupService();
    $response = $service->match( $criteria );
    echo json_encode( $response );
}
