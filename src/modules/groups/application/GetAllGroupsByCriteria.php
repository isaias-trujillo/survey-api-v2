<?php

namespace modules\groups\application;

use Error;
use modules\groups\domain\Group;
use modules\groups\domain\GroupRepository;
use modules\shared\domain\criteria\Criteria;

final class GetAllGroupsByCriteria
{
    private $repository;

    public function __construct(GroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Criteria $criteria): array
    {
        try {
            $groups = $this->repository->match( $criteria );
            $errors = array_map( function (Group $group) {
                if (!$group->valid()) {
                    return $group->errors();
                }
                return null;
            }, $groups );

            if (!empty( $errors = array_filter( $errors ) )) {
                return [ 'errors' => $errors ];
            }
            $offset = $criteria['offset'] ?? 0;
            $limit = $criteria['limit'] ?? 10;
            return [
                'page' => $offset ? round( ( $offset / $limit ) + 1 ) : 1,
                'per page' => $limit,
                'count' => count( $groups ),
                'records' => $groups
            ];

        } catch (Error $error) {
            return [ 'error' => $error->getMessage() ];
        }
    }
}