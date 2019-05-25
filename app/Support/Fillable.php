<?php

namespace App\Support;

abstract class Fillable
{
    /**
     * Lista de campos que podem ser preenchidos.
     * Defina para null para não restringir
     */
    protected $fields = [];

    /**
     * Função que permite adicionar lógica para obter os campos que podem ser preenchidos.
     */
    protected function getFields()
    {
        return $this->fields;
    }

    protected function canFill($key) : bool
    {
        if ($this->fields == null)
            return true;
        
        return (in_array($key, $this->getFields()));
    }
    
    /**
     * Preenche os campos deste objeto com os dados fornecidos
     * 
     * @param $data Dados para os campos desta classe
     */
    public function fill($data)
    {
        if (is_object($data))
            $data = (array) $data;

        foreach ($data as $key => $value)
        {
            if ($this->canFill($key))
                $this->{$key} = $value;
        }
    }
}