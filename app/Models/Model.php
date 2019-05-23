<?php

namespace App\Models;

use App\Support\StringHelper;

abstract class Model
{
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
        $class = explode('\\', __CLASS__);
        return array_pop($class);
    }
}