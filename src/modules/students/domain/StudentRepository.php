<?php

namespace modules\students\domain;

use modules\shared\domain\criteria\Criteria;

interface StudentRepository
{
    function find(Criteria $criteria) : Student;
}