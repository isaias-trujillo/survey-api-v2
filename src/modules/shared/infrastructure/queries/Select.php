<?php

namespace modules\shared\infrastructure\queries;

use Error;
use PDO;
use PDOException;

class Select
{
    private $query;
    private $parameters;

    public function __construct(string $query, array $parameters = [])
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }

    public function one(PDO $connection)
    {
        if (!( $statement = $connection->prepare( $this->query ) )) {
            throw new Error( "Invalid query." );
        }
        foreach ($this->parameters as $parameter => $value) {
            $statement->bindValue( $parameter, $value );
        }
        $statement->execute();
        return $statement->fetch( PDO::FETCH_ASSOC ) ?? [];
    }

    public function all(PDO $connection)
    {
        if (!( $statement = $connection->prepare( $this->query ) )) {
            throw new Error( "Invalid query." );
        }
        foreach ($this->parameters as $parameter => $value) {
            $statement->bindValue( $parameter, $value );
        }
        $statement->execute();
        return $statement->fetchAll( PDO::FETCH_ASSOC ) ?? [];
    }
}