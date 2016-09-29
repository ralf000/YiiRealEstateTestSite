<?php
namespace frontend\validators;

use yii\validators\Validator;

class TypeAdvertValidators extends Validator{
    
    public function validateAttribute($model, $attribute) {
        $value = $model->attribute;
        
        if(!in_array($value, ['Buy', 'Rent', 'Sale'])){
            $this->addError($model, $attribute, 'Not reqired value');
        }
    }
}