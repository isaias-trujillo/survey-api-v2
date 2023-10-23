<?php

namespace api\core;

use ArrayObject;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class Routes
    extends ArrayObject
{
    public function __construct()
    {
        $basename = basename( dirname( __DIR__ ) );
        $folderPath = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . "routes";
        $value = $this->generate( $folderPath, $basename );
        parent::__construct( $value );
    }

    public function offsetSet($key, $value) {}

    public function offsetUnset($key) {}

    private function generate(string $folderPath, string $basename): array
    {
        $routes = [];
        $dirIterator = new RecursiveDirectoryIterator( $folderPath );
        /** @var RecursiveDirectoryIterator | RecursiveIteratorIterator $it */
        $it = new RecursiveIteratorIterator( $dirIterator );

        // the valid() method checks if current position is valid e.g. there is a valid file or directory at the current position
        while ($it->valid()) {
            // isDot to make sure it is not current or parent directory
            if (!$it->isDot() && $it->isFile() && $it->isReadable()) {
                // $file is a SplFileInfo instance
                $file = $it->current();
                $filePath = $it->key();
                // do something about the file
                // ...
                if (!preg_match_all( "/\w+.php/", $filePath, $filename )) {
                    continue;
                }
                $route = self::build_route( $folderPath, $file, $basename );
                $method = strtolower( str_replace( ".php", "", $filename[0][0] ) );
                $routes[ $route ][ $method ] = $filePath;
            }
            $it->next();
        }
        return $routes;
    }

    private function build_route(string $folderPath, string $file, string $basename): string
    {
        // remove php file name
        $key = preg_replace( "/\w+(.php)/", "", str_replace( $folderPath, "", $file ) );
        // replace double backslash for single slash
        $key = str_replace( "\\", '/', "$basename$key" );
        // remove right slash
        return rtrim( $key, "/" );
    }
}