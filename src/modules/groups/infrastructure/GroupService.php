<?php

namespace modules\groups\infrastructure;

use modules\groups\application\GetAllGroupsByCriteria;
use modules\shared\domain\criteria\Criteria;

final class GroupService
{
    private $repository;

    public function __construct() {
        $this->repository = new MySqlGroupRepository();
    }

    public function match(Criteria $criteria): array
    {
        $case = new GetAllGroupsByCriteria($this->repository);
        return $case($criteria);
    }
}