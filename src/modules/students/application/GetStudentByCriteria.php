<?php

namespace modules\students\application;

use modules\shared\domain\criteria\Criteria;
use modules\students\domain\Student;
use modules\students\domain\StudentRepository;

final class GetStudentByCriteria
{
    private $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Criteria $criteria): Student
    {
        return $this->repository->find( $criteria );
    }
}