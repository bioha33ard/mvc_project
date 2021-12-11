<?php

namespace app\Http\Requests;

use app\core\Interfaces\FormRequest;
use Inhere\Validate\FieldValidation;
use stdClass;

class PostRequest extends FieldValidation implements FormRequest
{
    
    
    public function rules(): array
    {
        
        return [
            ['email', 'required|min:5', 'filter' => 'string'],
            ['password', 'required', 'filter' => 'string'],
        ];
    }
    
    
    public static function checkError($post): array|int|stdClass
    {
        
        $validator = self::check($post);
        if ($validator->isFail()) {
            return failed($validator->getErrors(), 422);
        }
        
        return $validator->safeData();
    }
    
}