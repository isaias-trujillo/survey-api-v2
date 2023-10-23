<?php

namespace modules\teachers\domain;

use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\fields\Id;

interface TeacherRepository
{

    function find(Criteria $criteria) : Teacher;
}