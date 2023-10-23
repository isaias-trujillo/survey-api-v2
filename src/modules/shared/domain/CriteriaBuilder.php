<?php

namespace modules\shared\domain;

use modules\shared\domain\criteria\Criteria;
use modules\shared\domain\criteria\Filter;

final class CriteriaBuilder
{
    private $data = [];

    function filter(Filter $filter): CriteriaBuilder
    {
        $this->data['filter'] = $filter;
        return $this;
    }

    function order_by(string $field, string $type = 'asc'): CriteriaBuilder
    {
        $this->data['order by'][ $field ] = [
            'name' => $field,
            'type' => $type
        ];
        return $this;
    }

    public function limit(int $limit): CriteriaBuilder
    {
        $this->data['limit'] = $limit;
        return $this;
    }

    public function offset(int $offset): CriteriaBuilder
    {
        $this->data['offset'] = $offset;
        return $this;
    }

    function build(): Criteria
    {
        return new Criteria( $this->data );
    }
}