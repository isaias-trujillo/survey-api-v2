<?php

namespace api\core;

use ArrayObject;

final class Parameters
{
    private function __construct() {}

    public static function of(string $route){
        $values = self::search( $route );
        return count($values) ? $values : null;
    }

    public static function check(string $fragment): bool
    {
        return !empty( self::parse( $fragment ) );
    }

    private static function parse(string $fragment)
    {
        if (!preg_match_all( "/{{(\w+)}}/", $fragment, $matches )) {
            return null;
        }
        if (count( $matches ) < 2) {
            return null;
        }
        if (empty( $matches[1] ) ) {
            return null;
        }
        return $matches[1][0];
    }

    private static function search(string $route): array
    {
        $url = $_REQUEST['url'];
        $fragments = [
            'route' => explode( "/", $route ) ?? [],
            'request' => explode( "/", $url ) ?? [],
        ];

        $diff = array_diff( $fragments['route'], $fragments['request'] );
        if (empty( $diff )) {
            return [];
        }

        $params = [];
        foreach ($diff as $index => $fragment) {
            // Check if fragment is not a parameter, e.g.:
            // route    =>  api/v1/users/{{groupId}} , where {{groupId}} is a fragment
            // url      =>  api/v1/users/123         , where 123 is a parameter
            if (!( $name = Parameters::parse( $fragment ) )) {
                continue;
            }
            $value = $fragments['request'][ $index ];
            $params[ $name ] = $value;
        }

        return $params;
    }
}