<?php

namespace modules\shared\domain\criteria;

use ArrayObject;

final class Filter extends ArrayObject
{
    public function __construct(array $data)
    {
        parent::__construct( $data );
    }

    public static function of(string $field, string $operator, $value): Filter
    {
        return new Filter( [
            'field' => $field,
            'operator' => $operator,
            'value' => $value,
        ] );
    }

    public function and(Filter $filter): Filter
    {
        if (!isset( $this['next'] )) {
            $this['join'] = 'and';
            $this['next'] = $filter;
            return $this;
        }
        $current = &$this;
        while ($current && $current->has_next()) {
            $current = $current['next'] ?? null;
        }
        $current['join'] = 'and';
        $current['next'] = $filter;

        return $this;
    }

    public function or(Filter $filter): Filter
    {
        $this['join'] = 'or';
        $this['next'] = $filter;
        return $this;
    }

    public function has_next(): bool
    {
        return isset( $this['next'] );
    }
}