<?php

namespace App\Models;

use Exception;

use App\Support\StringHelper;

use App\Database\QueryBuilder;
use App\Database\ConnectionManager;

abstract class Model
{    
    private $queryBuilder = null;
    
    protected $connection = null;
    
    protected $tableName = null;
    protected $primaryKey = 'id';
    protected $timestamps = true;

    protected $createdColumn = 'created_at';
    protected $updatedColumn = 'updated_at';

    protected $fields = [];
    protected $hidden = [];

    protected function getTableName()
    {
        if ($this->tableName != null)
            return $tableName;

        return StringHelper::toSnakeCase($this->getShortClassName());
    }

    protected function getColumns(bool $public = false)
    {
        $columns = $this->fields;

        if ($this->primaryKey != null)
            $columns[] = $this->primaryKey;

        if ($this->timestamps)
        {
            $columns[] = $this->createdColumn;
            $columns[] = $this->updatedColumn;
        }

        if ($public)
        {
            for ($i = 0, $len = count($this->hidden); $i < $len; $i++)
            {
                if (key_exists($this->hidden[$i], $columns))
                    unset($columns[$this->hidden[$i]]);
            }
        }
    }

    protected function getKeyedData(bool $public = false)
    {
        $columns = $this->getColumns($public);

        $data = array();

        foreach ($columns as $column)
        {            
            $data[$column] = $this->{$column};
        }

        return $data;
    }

    protected function getShortClassName() : string
    {        
        $class = explode('\\', get_called_class());
        return array_pop($class);
    }

    private function getQueryBuilder(bool $save = true)
    {
        if ($this->queryBuilder == null)
            $this->queryBuilder = QueryBuilder::table($this->getTableName());

        $result = $this->queryBuilder;

        if (!$save)
            $this->queryBuilder = null;
        
        return $result;
    }

    protected function insert(QueryBuilder $query)
    {
        $data = $this->getKeyedData();

        unset($data[$this->primaryKey]);

        if ($this->timestamps)
        {
            $now = date('Y-m-d H:i:s');

            $data[$this->createdColumn] = $now;
            $data[$this->updatedColumn] = $now;
        }

        return $this->query->insert(array_keys($data), array_values($data));
    }

    protected function update(QueryBuilder $query)
    {
        $data = $this->getKeyedData();

        if ($this->timestamps)
        {
            $data[$this->updatedColumn] = date('Y-m-d H:i:s');
        }

        return $this->query->update($data);
    }

    public function save()
    {
        $query = $this->getQueryBuilder(false);

        if (empty($this->{$this->primaryKey}))
            return $this->insert($query);

        return $this->update($query);
    }

    public function get()
    {
        if ($this->queryBuilder == null)
            throw new Exception('Model query is empty.');

        $sql = $this->queryBuilder->toSql();
        $this->queryBuilder = null;

        return ConnectionManager::getInstance()->getConnection($this->connection)->select($sql);
    }

    public function where(string $column, $value, string $condtion = '=') : Model
    {
        $query =  $this->getQueryBuilder();

        if ($query->isEmpty())
            $query->select('*');

        $query->where($column, $value, $condtion);
        
        return $this;
    }

    public static function find($primaryKey) : Model
    {
        $instance = new static();
        
        $query = $instance->getQueryBuilder(false)
                    ->select('*')
                    ->where($instance->primaryKey, $primaryKey);

        return ConnectionManager::getInstance()->getConnection($instance->connection)
            ->selectOne($query->toSql());
    }

    public static function new() : Model
    {
        return new static();
    }
}