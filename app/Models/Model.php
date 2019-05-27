<?php

namespace App\Models;

use Exception;

use App\Support\StringHelper;
use App\Support\ArrayHelper;
use App\Support\Fillable;

use App\Database\QueryBuilder;
use App\Database\ConnectionManager;

use App\Exceptions\RecordNotFoundException;

abstract class Model extends Fillable
{    
    private $queryBuilder = null;
    
    protected $connection = null;
    
    protected $tableName = null;
    protected $primaryKey = 'id';
    protected $timestamps = true;

    protected $createdColumn = 'created_at';
    protected $updatedColumn = 'updated_at';

    protected $hidden = [];

    private function getQueryBuilder(bool $save = true) : QueryBuilder
    {
        if ($this->queryBuilder == null)
            $this->queryBuilder = QueryBuilder::table($this->getTableName());

        $result = $this->queryBuilder;

        if (!$save)
            $this->queryBuilder = null;
        
        return $result;
    }

    protected function getFields()
    {
        $fields = $this->fields;

        if ($this->primaryKey != null)
            $fields[] = $this->primaryKey;

        if ($this->timestamps)
        {
            $fields[] = $this->createdColumn;
            $fields[] = $this->updatedColumn;
        }

        return $fields;
    }

    protected function insert(QueryBuilder $query) : QueryBuilder
    {
        $data = $this->toArray();

        unset($data[$this->primaryKey]);

        if ($this->timestamps)
        {
            $now = date('Y-m-d H:i:s');

            $data[$this->createdColumn] = $now;
            $data[$this->updatedColumn] = $now;
        }

        return $query->insert(array_keys($data), [array_values($data)]);
    }

    protected function update(QueryBuilder $query) : QueryBuilder
    {
        $data = $this->toArray();

        if ($this->timestamps)
        {
            $data[$this->updatedColumn] = date('Y-m-d H:i:s');
        }

        return $query->update($data);
    }

    protected function getTableName() : string
    {
        if ($this->tableName != null)
            return $tableName;

        return StringHelper::toSnakeCase($this->getShortClassName());
    }

    protected function getColumns(bool $public = false) : array
    {
        $columns = $this->getFields();

        if ($public)
        {
            $columns = ArrayHelper::except($columns, $this->hidden);
        }

        return $columns;
    }

    protected function getShortClassName() : string
    {        
        $class = explode('\\', get_called_class());
        return array_pop($class);
    }

    /**
     * Obtém o valor da chave primária do registro ou null caso a mesma não definida
     */
    public function getPrimaryKeyValue()
    {
        if (!isset($this->{$this->primaryKey}))
            return null;
        
        return $this->{$this->primaryKey};
    }

    /**
     * Obtém um array com os valores do registro no estilo Key-Value.
     * 
     * @param bool $public Indica se os campos protegidos devem ser ocultos
     */
    public function toArray(bool $public = false) : array
    {
        $columns = $this->getColumns($public);

        $data = array();

        foreach ($columns as $column)
        {            
            if (isset($this->{$column}))
                $data[$column] = $this->{$column};
        }

        return $data;
    }

    /**
     * Obtém um json com os valores do registro.
     * 
     * @param bool $public Indica se os campos protegidos devem ser ocultos
     * 
     * @throws \Exception Caso não seja possível serializar para json
     */
    public function toJson(bool $public = false) : string
    {
        $data = $this->toArray($public);

        $result = json_encode($data);

        if ($result === false)
        {
            throw new Exception(
                "Não foi possível serializar \"{$this->getShortClassName()}\" para json"
            );
        }

        return $result;
    }

    public function save() : bool
    {
        $query = $this->getQueryBuilder(false);

        if ($this->getPrimaryKeyValue() == null)
            $query = $this->insert($query);
        else
            $query = $this->update($query);

        $saved = (ConnectionManager::getConnection($this->connection)
                    ->executeStatement($query->toSql()) > 0);

        if ($saved && empty($this->id))
            $this->id = ConnectionManager::getConnection()->getLastInsertedId();

        return $saved;
    }

    public function delete() : bool
    {        
        if ($this->getPrimaryKeyValue() == null)
            return false;

        $query = $this->getQueryBuilder(false)
                        ->delete()
                        ->where($this->primaryKey, $this->getPrimaryKeyValue());
        
        return (ConnectionManager::getConnection($this->connection)
                    ->executeStatement($query->toSql()) > 0);
    }

    public function get()
    {
        if ($this->queryBuilder == null)
            throw new Exception('Model query is empty.');

        $sql = $this->queryBuilder->toSql();
        $this->queryBuilder = null;

        $records = ConnectionManager::getConnection($this->connection)->select($sql);

        $result = array();

        $instance = null;

        for ($i = 0, $len = count($records); $i < $len; $i++)
        {
            $instance = new static();
            $instance->fill($records[$i]);
            
            $result[] = $instance;
        }

        return $result;
    }

    public function where(string $column, $value, string $condtion = '=') : Model
    {
        $this->getQueryBuilder();

        if ($this->queryBuilder->isEmpty())
            $this->queryBuilder->select('*');

        $this->queryBuilder->where($column, $value, $condtion);
        
        return $this;
    }

    public function whereRaw(string $condition) : Model
    {
        $this->getQueryBuilder();

        if ($this->queryBuilder->isEmpty())
            $this->queryBuilder->select('*');

        $this->queryBuilder->whereRaw($condition);
        
        return $this;
    }

    public function firstOrFail()
    {
        $query = $this->getQueryBuilder(false);

        $record = ConnectionManager::getConnection($this->connection)
                    ->selectOne($query->toSql());
                    
        if ($record == null)
        {
            throw new RecordNotFoundException(
                $this->getTableName(),
                $query->getConditions()
            );
        }

        $this->fill($record);

        return $this;
    }

    public static function findOrFail($primaryKey)
    {
        $instance = new static();
        
        $instance->queryBuilder = $instance->getQueryBuilder()
                                    ->select('*')
                                    ->where($instance->primaryKey, $primaryKey);

        return $instance->firstOrFail();
    }

    public static function find($primaryKey)
    {
        try
        {
            return self::findOrFail($primaryKey);
        }
        catch (\Throwable $th) { }

        return null;
    }

    public static function new() : Model
    {
        return new static();
    }
}