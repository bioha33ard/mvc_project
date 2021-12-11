<?php

namespace app\Http\Requests;

use Inhere\Validate\FieldValidation;
use stdClass;

class RegisterRequest extends FieldValidation implements FormRequest
{
    
    public function rules(): array
    {
        
        return [
            ['first_name', 'required|min:5', 'filter' => 'string'],
            ['last_name', 'required|min:5', 'filter' => 'string'],
            ['email', 'required|email', 'filter' => 'string'],
            ['password', 'required|min:6|max:20', 'filter' => 'string'],
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