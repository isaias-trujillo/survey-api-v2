<?php

namespace modules\shared\infrastructure\queries;

use Error;
use PDO;
use PDOException;

class Insert
{
    private $query;
    private $parameters;

    public function __construct(string $query, array $parameters)
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }

    public function __invoke(PDO $connection)
    {
        try {
            $connection->beginTransaction();
            if (!( $statement = $connection->prepare( $this->query ) )) {
                throw new Error( "Invalid query." );
            }
            foreach ($this->parameters as $parameter => $value) {
                $statement->bindValue( $parameter, $value );
            }
            if ($connection->inTransaction()) {
                $connection->commit();
            }
            return $statement->execute();
        } catch (PDOException $exception) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            return [ 'error' => $exception->getMessage() ];
        }
    }
}