<?php

namespace api\core;

use ArrayObject;
use Error;

final class Request extends ArrayObject
{
    public function __construct()
    {
        $route = Request::request_api_route();

        parent::__construct( [
            'parameters' => Parameters::of($route),
            'query' => Request::query(),
            'body' => Request::body(),
        ] );
    }

    private static function request_api_route(): string
    {
        try {
            $route = str_replace( getcwd() . "\\src", "", dirname( debug_backtrace()[1]['file'] ) );
            $route = str_replace( "\\", "/", $route );
            $route = ltrim( $route, "/" );
            return str_replace( "/routes", "", $route );
        } catch (Error $error) {
            return "";
        }
    }

    public static function parameters()
    {
        $route = Request::request_api_route();
        return Parameters::of($route);
    }

    public static function query()
    {
        $url = parse_url( $_SERVER['REQUEST_URI'] );
        $method = strtolower( $_SERVER['REQUEST_METHOD'] );
        $query = null;
        if ($method === "get" && isset( $url['query'] )) {
            parse_str( $url['query'], $query );
        }
        return $query;
    }

    public static function body()
    {
        $method = strtolower( $_SERVER['REQUEST_METHOD'] );
        $body = null;
        if ($method === "post" || $method === "put" || $method === "patch") {
            if (empty( $_POST ) || !count( $_POST )) {
                $body = json_decode( file_get_contents( 'php://input' ), true ) ?? [];
            } else {
                $body = $_POST;
            }
        }
        return $body;
    }
}