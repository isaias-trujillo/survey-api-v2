<?php

namespace modules\shared\infrastructure;

use Error;
use PDO;
use PDOException;
use PDOStatement;

class MySqlRepository extends SqlRepository
{
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this['host']};port={$this['port']};dbname={$this['database']}";
            $connection = new PDO( $dsn, $this['user'], $this['password'] );
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            return $connection;
        } catch (PDOException $exception) {
            throw new Error("Error when connecting to the database");
        }
    }
}