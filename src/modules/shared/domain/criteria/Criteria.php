<?php

namespace modules\shared\domain\criteria;

use ArrayObject;
use modules\shared\domain\CriteriaBuilder;

class Criteria extends ArrayObject
{
    public function __construct(array $array = [])
    {
        parent::__construct( $array );
    }

    public static function builder(): CriteriaBuilder
    {
        return new CriteriaBuilder();
    }

    function empty(): bool
    {
        return empty( $this );
    }

    function sql(string $query = null): array
    {
        if ($this->empty()) {
            return [
                'conditions' => null,
                'parameters' => null
            ];
        }
        $index = 0;
        $conditions = "";
        $parameters = [];
        $current = $this['filter'] ?? null;
        while ($current) {
            $field = $current['field'];
            $operator = $current['operator'];

            if (( $operator === "is" || $operator === "is not" ) && ( $current['value'] == 'null' || is_null( $current['value'] ) )) {
                $condition = " $field $operator NULL";
            } else {
                $condition = " $field $operator :condition_$index ";
                $parameters["condition_$index"] = $current['value'];
            }

            if ($current->has_next()) {
                $join = $current['join'];
                $conditions .= $condition . $join;
                $current = $current['next'];
            } else {
                $conditions .= $condition;
                $current = null;
            }
            $index++;
        }

        $limit = $this['limit'] ?? null;
        $offset = $this['offset'] ?? 0;

        $query = strtr( $query, [
            '%conditions' => !empty( $conditions ) ? " where $conditions" : "",
            '%order_by' => '',
            '%pagination' => $limit ? "limit $limit offset $offset" : ""
        ] );

        return [
            'query' => $query,
            'parameters' => $parameters,
        ];
    }
}