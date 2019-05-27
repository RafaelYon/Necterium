<?php

namespace App\Database;

use App\Support\StringHelper;
use App\Database\ConnectionManager;

class QueryBuilder
{
    protected $table = null;
    protected $command = null;
    protected $fields = array();
    protected $values = array();
    protected $conditions = array();
    protected $joins = array();
    protected $groupBy = array();
    protected $orderBy = array();
    protected $limit = null;

    private function __construct() { }

    protected function setCommand(string $command)
    {
        $this->command = $command;
    }

    public function isEmpty() : bool
    {
        if ($this->command != null)
            return false;
        
        if (!empty($this->fields))
            return false;

        if (!empty($this->values))
            return false;

        if (!empty($this->conditions))
            return false;

        if (!empty($this->joins))
            return false;

        if (!empty($this->groupBy))
            return false;

        if (!empty($this->orderBy))
            return false;

        if ($this->limit != null)
            return false;

        return true;
    }

    public static function table(string $table) : QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->table = $queryBuilder->protectedColumn($table);

        return $queryBuilder;
    }

    private function addField($field)
    {
        if (!is_string($field))
            return;
        
        $this->fields[] = $this->protectedColumn($field);
    }

    public function select($fields) : QueryBuilder
    {
        $this->setCommand('SELECT');

        if (!is_array($fields))
            $fields = array($fields);
        
        foreach ($fields as $field)
        {
            $this->addField($field);
        }

        return $this;
    }

    public function insert(array $columns, array $values) : QueryBuilder
    {
        $this->setCommand('INSERT');
        
        if (empty($columns) || empty($values))
            return $this;

        foreach ($columns as $column)
        {
            $this->addField($column);
        }

        foreach ($values as $vs)
        {
            for ($i = 0, $len = count($vs); $i < $len; $i++)
            {
                $vs[$i] = $this->protectedValue($vs[$i]);
            }

            $this->values[] = '(' . implode(', ', $vs) . ')';
        }

        return $this;
    }

    public function update(array $data) : QueryBuilder
    {
        $this->setCommand('UPDATE');

        if (empty($data))
            return $this;
        
        foreach ($data as $key => $value)
        {              
            $this->values[] = $this->protectedColumn($key) . ' = ' . $this->protectedValue($value);
        }

        return $this;
    }

    public function delete() : QueryBuilder
    {
        $this->setCommand('DELETE');

        return $this;
    }

    protected function protectedColumn($column) : string
    {
        return '`' . $column . '`';
    }

    protected function protectedValue($value)
    {        
        if ($value == null)
            $value = 'NULL';

        $value = ConnectionManager::getConnection()->quote($value);

        return $value;
    }

    public function where(string $column, $value, string $condition = '=') : QueryBuilder
    {        
        return $this->whereRaw(implode(' ', [
            $this->protectedColumn($column), $condition, $this->protectedValue($value)
        ]));
    }

    public function whereRaw(string $raw) : QueryBuilder
    {
        $this->conditions[] = $raw;

        return $this;
    }

    protected function addJoin(string $type, string $table, 
        string $column1, string $condition, string $column2)
    {
        $this->joins[] = implode(' ', [
            $type, $table, 'ON', 
            $this->protectedColumn($column1),
            $condition, 
            $this->protectedColumn($column2)
        ]);
    }

    public function join(string $table, string $column1, string $condition, string $column2) : QueryBuilder
    {
        $this->addJoin('INNER JOIN', $table, $column1, $condition, $column2);

        return $this;
    }

    public function leftJoin(string $table, string $column1, string $condition, string $column2) : QueryBuilder
    {
        $this->addJoin('LEFT JOIN', $table, $column1, $condition, $column2);

        return $this;
    }

    public function rightJoin(string $table, string $column1, string $condition, string $column2) : QueryBuilder
    {
        $this->addJoin('RIGHT JOIN', $table, $column1, $condition, $column2);

        return $this;
    }

    public function groupBy(string $column, $type = 'ASC') : QueryBuilder
    {
        $this->groupBy[] = $this->protectedColumn($column);

        return $this;
    }

    public function orderBy(string $column, $type = 'ASC') : QueryBuilder
    {
        $this->orderBy[] = $this->protectedColumn($column) . ' ' . $type;

        return $this;
    }

    public function limit(string $limit) : QueryBuilder
    {
        $this->limit = $limit;

        return $this;
    }

    public function toSql() : string
    {
        $tableNameAdded = false;
        
        $sql = $this->command . ' ';

        if ($this->command == 'INSERT')
        {
            $sql .= 'INTO ' . $this->table . ' ';

            $tableNameAdded = true;
        }
        else if ($this->command == 'UPDATE')
        {
            $sql .= $this->table . ' ';

            $tableNameAdded = true;
        }

        if (!empty($this->fields))
        {
            $fields = implode(', ', $this->fields);

            if (!empty($this->values))
                $fields = '(' . $fields . ')';

            $sql .= $fields . ' ';
        }

        if ($this->command == 'INSERT')
        {
            $sql .= 'VALUES ';
        }
        else if ($this->command == 'UPDATE')
        {
            $sql .= 'SET ';
        }

        if (!empty($this->values))
        {
            $sql .= implode(', ', $this->values) . ' ';
        }

        if (!$tableNameAdded)
        {
            $sql .= 'FROM ' . $this->table . ' ';
        }

        if (!empty($this->joins))
        {
            $sql .= implode(' ', $this->joins) . ' ';
        }

        if (!empty($this->conditions))
        {
            $sql .= 'WHERE ' . implode(' AND ', $this->conditions) . ' ';
        }

        if (!empty($this->groupBy))
        {
            $sql .= implode(', ', $this->groupBy) . ' ';
        }

        if (!empty($this->orderBy))
        {
            $sql .= implode(', ', $this->orderBy) . ' ';
        }

        if ($this->limit != null)
        {
            $sql .= 'LIMIT ' . $this->limit;
        }

        return $sql;
    }

    public function getConditions() : array
    {
        return $this->conditions;
    }
}