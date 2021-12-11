<?php

namespace app\core\lib\QueryBuilder;

trait BuildFields
{
    
    /**
     * @param  array  $data
     *
     * @return string
     */
    public function buildFieldsString(array $data): string
    {
        
        return implode(' , ', $this->buildFields($data));
    }
    
    /**
     * @param  array  $data
     *
     * @return string
     */
    protected function where(array $data): string
    {
        
        $keys = $this->buildFields($data);
        
        return (count($data) > 1) ? implode(' AND ', $keys)
            : implode('', $keys);
    }
    
    /**
     * @param  array  $data
     *
     * @return array
     */
    protected function buildFields(array $data): array
    {
        
        return array_map(static fn($items) => "$items = :$items", $data);
    }
    
}