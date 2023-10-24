<?php

namespace modules\teachers\application;

use Error;
use modules\shared\domain\criteria\Criteria;
use modules\teachers\domain\DNI;
use modules\teachers\infrastructure\filters\FilterByDNI;

final class FindTeacherByDNI extends UseCase
{
    public function __invoke(DNI $dni): array
    {
        if (!$dni->valid()) {
            return [ 'error' => $dni->error() ];
        }
        try {
            $filter = FilterByDNI::of($dni['value']);
            $criteria = Criteria::builder()->filter($filter)->build();
            $teacher= $this->repository->find( $criteria );
            if (!$teacher->valid()){
                return ['errors' => $teacher->errors()];
            }
            return (array) $teacher;
        } catch (Error $error) {
            return [ 'error' => $error->getMessage() ];
        }
    }
}