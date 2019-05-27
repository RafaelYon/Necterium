<?php

namespace App\Database;

use PDO;
use PDOStatement;

class Connection
{
    private $pdo;

    public function __construct(string $connectionKey)
    {
        $config = config(implode('.', ['database', 'connections', $connectionKey]));

        $this->pdo = new PDO(
            $config['driver'] . ':host=' . $config['host']
            . ';port=' . $config['port']
            . ';dbname=' . $config['database']
            . ';charset=' . $config['charset'],
            $config['username'], $config['password']
        );

        if (config('app.debug'))
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function bindValues($statement, $bindings)
    {
        if (empty($bindings))
            return;

        foreach ($bindings as $key => $value)
        {
            $bindType = PDO::PARAM_STR;
            
            if (is_int($key))
            {
                $key += 1;
                $bindType = PDO::PARAM_INT;
            }
            
            $statement->bindValue($key, $value, $bindType);
        }
    }

    protected function execute(string $query, $bindings) : PDOStatement
    {
        $statement = $this->pdo->prepare($query);

        $statement->setFetchMode(PDO::FETCH_OBJ);

        $this->bindValues($statement, $bindings);

        $statement->execute();

        return $statement;
    }

    public function executeStatement(string $query, $bindings = []) : int
    {        
        return $this->execute($query, $bindings)->rowCount();
    }

    public function select(string $query, $bindings = []) : array
    {
        return $this->execute($query, $bindings)->fetchAll();
    }

    public function selectOne(string $query, $bindings = [])
    {
        $results = $this->select($query, $bindings);

        return array_shift($results);
    }

    public function getLastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    public function quote($data)
    {
        return $this->pdo->quote($data);
    }
}