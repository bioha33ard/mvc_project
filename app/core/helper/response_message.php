<?php

/**
 * @throws JsonException
 */
function ok(array $data, int $code = 200): int
{
    
    $array = [
        'data' => $data,
        'code' => $code,
    ];
    
    return print json_encode($array, JSON_THROW_ON_ERROR);
}
/**
 * @throws JsonException
 */
function failed(array $data, $code = null, array $trace = null): int
{
    
    $array = [
        'data'  => $data,
        'code'  => $code,
        'trace' => $trace,
    ];
    
    return print json_encode($array, JSON_THROW_ON_ERROR);
}