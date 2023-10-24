<?php

namespace modules\students\infrastructure;

use Error;
use modules\shared\domain\criteria\Criteria;
use modules\students\application\GetStudentByCriteria;

final class StudentService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MySqlStudentRepository();
    }

    function match(Criteria $criteria)
    {
        try {
            $case = new GetStudentByCriteria( $this->repository );
            $student = $case( $criteria );
            if (!$student->valid()){
                return ['errors' => $student->errors()];
            }
            return $student;
        } catch (Error $error) {
            return [ 'error' => $error->getMessage() ];
        }
    }
}