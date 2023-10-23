<?php

namespace api\core;

use Error;
use Exception;

final class App
{
    private function __construct() {}

    public static function run()
    {
        try {
            self::execute();
            return;
        } catch (Error $error) {
            http_response_code( 404 );
            echo json_encode( [
                'error' => $error->getMessage(),
            ] );
        } catch (Exception $exception) {
            http_response_code( 404 );
            echo json_encode( [
                'error' => $exception->getMessage(),
            ] );
        }
    }

    private static function execute()
    {
        $routes = new Routes();
        $url = $_REQUEST['url'];

        foreach ($routes as $route => $controllers) {
            if ($route === $url) {
                self::call_controller( $controllers );
                return;
            }

            if (!( $fragments['route'] = explode( "/", $route ) )) {
                return;
            }

            if (!( $fragments['request'] = explode( "/", $url ) )) {
                return;
            }

            if (count( $fragments['route'] ) !== count( $fragments['request'] )) {
                continue;
            }

            $bound = count( $fragments['route'] );

            $check = true;

            for ($i = 0; $i < $bound; $i++) {
                if ($fragments['route'][ $i ] === $fragments['request'][ $i ]) {
                    continue;
                }
                if (!( $check = Parameters::check( $fragments['route'][ $i ] ) )) {
                    break;
                }
            }

            if (!$check) {
                continue;
            }

            self::call_controller( $controllers );
            return;
        }
        echo json_encode( [
            'error' => 'Route not found. 😭',
        ] );
    }

    private static function call_controller(array $controllers)
    {
        if (empty( $controllers )) {
            echo json_encode( [
                'error' => "There are not controllers for request route. 😕",
            ] );
            return;
        }

        $method = strtolower( $_SERVER['REQUEST_METHOD'] );

        if (!( $file = $controllers[ $method ] ?? null )) {
            echo json_encode( [
                'error' => 'Method not supported. 😩',
            ] );
            return;
        }
        if (!file_exists( $file )) {
            echo json_encode( [
                'error' => "Controller not found. 😕",
            ] );
            return;
        }
        require_once $file;
    }
}