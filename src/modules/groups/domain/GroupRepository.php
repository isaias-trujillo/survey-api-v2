<?php

namespace modules\groups\domain;

use modules\shared\domain\criteria\Criteria;

interface GroupRepository
{
    function match(Criteria $criteria) : array;
}