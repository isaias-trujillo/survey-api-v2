<?php

namespace modules\teachers\application;

use modules\teachers\domain\TeacherRepository;

abstract class UseCase
{
    protected $repository;

    public function __construct(TeacherRepository $repository)
    {
        $this->repository = $repository;
    }
}