<?php

namespace modules\teachers\application;

use Error;
use modules\teachers\domain\DNI;
use modules\teachers\infrastructure\criteria\FilterByDNI;

final class FindTeacherByDNI extends UseCase
{
    public function __invoke(DNI $dni): array
    {
        if (!$dni->valid()) {
            return [ 'error' => $dni->error() ];
        }
        try {
            $criteria = FilterByDNI::of($dni['value']);
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