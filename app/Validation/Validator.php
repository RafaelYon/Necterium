<?php

namespace App\Validation;

use App\Http\Request;
use App\Exceptions\ValidationException;
use App\Security\Csrf;
use App\Database\ConnectionManager;
use App\Database\QueryBuilder;

class Validator
{
    public static function verify(array $inputRules, Request $request) : array
    {
        $data = [];
        $errors = [];

        foreach ($inputRules as $field => $rulesData)
        {
            $rules = [];
            
            if (is_array($rulesData))
            {
                $rules = $rulesData;
            }
            else
            {
                $rules = explode('|', $rulesData);
            }

            $result = self::handlerRules($request->getInput($field), $field, $rules);

            if (!empty($result))
                $errors[$field] = $result;
            else
                $data[$field] = $request->getInput($field);
        }

        if (empty($errors))
            return $data;

        throw new ValidationException($errors, $request);
    }

    private static function handlerRules($input, $field, array $rules)
    {
        // Carrega mensagens apenas uma vez
        $messages = config('validation.messages');
        $fields = config('lang.fields');

        $errors = [];
        
        foreach ($rules as $rule)
        {
            $parts = explode(':', $rule);

            if (!isset($parts[1]))
                $parts[1] = null;

            $result = self::checkRule($input, $parts[0], $parts[1], $field, $messages, $fields);

            if ($result !== true)
                $errors[] = $result;
        }

        return $errors;
    }

    private static function checkRule($input, $rule, $param, $field, $messages, $fileds)
    {
        $params = explode(',', $param);

        switch ($rule)
        {
            case 'required':
                if (is_numeric($input) || !empty($input))
                    return true;

                break;
            case 'string':
                if (is_string($input))
                    return true;
                
                break;
            case 'numeric':
                if (is_numeric($input))
                    return true;

                break;
            case 'max':
                if (strlen($input) <= $params[0])
                    return true;

                break;
            case 'min':
                if (strlen($input) >= $params[0])
                    return true;

                break;
            case 'email':
                if (filter_var($input, FILTER_VALIDATE_EMAIL))
                    return true;
                
                break;
            case 'regex':
                if (preg_match($params[0], $input))
                    return true;

                break;
            case 'csrf':
                if (Csrf::check($input))
                    return true;
                
                break;
            case 'unique':
                $sql = QueryBuilder::table($params[0])
                        ->select('*')
                        ->where($params[1], $input)
                        ->toSql();

                if (empty(ConnectionManager::getConnection()->selectOne($sql)))
                    return true;

                break;
        }

        $fieldText = $fileds[$field];
        $message = str_replace('{field}', $fieldText, $messages[$rule]);
        
        foreach ($params as $key => $param)
        {
            $message = str_replace("{params:$key}", $param, $message); 
        }

        return $message;
    }
}