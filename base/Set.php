<?php

/**
 * Check if the current variable isn't a null value.
 *
 * @param mixed $var the variable to evaluate
 * @return bool true if not null, false otherwise
 */
function is_not_null($var)
{
    return !is_null($var);
}

/**
 * Convert to under_score.
 *
 * @param string $input to convert
 * @return string $ouput converted
 */
function to_under_score($input)
{
    $output = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $input)), '_');

    return $output;
}

/**
 * Validate simple parameters if exist and not empty
 *
 * @param mixed / unlimited all parameters that needs to validate
 * @return bool true if validate was succeful, false otherwise
 */
function validate_params()
{
    $args = func_get_args();
    foreach ($args as $arg) {
        if (!$arg) {
            return false;
        }
    }

    return true;
}

/**
 * Check if the current db criteria value have a db flag
 * To pass a criteria value with a db flags needs to write "=:=" without quotes
 * beetween the flag and the value, example : ['id' => '<>=:=$value']
 *
 * @param $value
 * @return array
 */
function check_db_query_flag($value)
{
    $array = explode('=:=', $value);

    if (count($array) == 1) {

        return false;
    } else if (count($array) > 1) {

        return $array;
    }
}