<?php

namespace modules\shared\infrastructure;

use ArrayObject;
use Closure;
use Error;
use PDO;
use PDOException;
use PDOStatement;

abstract class SqlRepository extends ArrayObject
{
    public function __construct(string $host = null, string $user = null, string $password = null, string $database = null, string $port = null)
    {
        parent::__construct( [
            'host' => $host ?? $_ENV['MYSQL_HOST'],
            'user' => $user ?? $_ENV['MYSQL_USER'],
            'password' => $password ?? $_ENV['MYSQL_PASS'],
            'database' => $database ?? $_ENV['MYSQL_DATABASE'],
            'port' => $port ?? $_ENV['MYSQL_PORT']
        ] );
    }

    protected abstract function connect(): PDO;
}