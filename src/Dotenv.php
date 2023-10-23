<?php

final class Dotenv
{
    private function __construct() {}

    public static function load(string $environment = 'dev')
    {
        $path = str_replace( "\\", DIRECTORY_SEPARATOR, getcwd() );
        if (!( $files = scandir( $path ) )) {
            return;
        }
        $environments = [];
        foreach ($files as $file) {
            if (!preg_match( '/(.env)$/', $file )) {
                continue;
            }
            $name = str_replace( ".env", "", $file );
            $name = trim( $name, "\." );
            $environments[ $name ] = $file;
        }

        if (!array_key_exists( $environment, $environments )) {
            return;
        }

        $path = $environments[ $environment ];
        if (!file_exists( $path )) {
            return;
        }

        if (!( $lines = file( $path ) )) {
            return;
        }

        foreach ($lines as $line) {
            if (!( $fragments = explode( '=', $line, 2 ) )) {
                continue;
            }

            if (count( $fragments ) < 2) {
                continue;
            }

            $key = $fragments[0];
            $value = $fragments[1];

            $key = trim( $key );
            $value = trim( $value );

            putenv( sprintf( '%s=%s', $key, $value ) );
            $_ENV[ $key ] = $value;
        }
    }
}