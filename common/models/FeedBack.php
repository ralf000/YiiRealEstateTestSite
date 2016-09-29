<?php

namespace common\models;

use yii\base\Model;
 
class FeedBack extends Model{
    
    public $email;
    public $name;
    public $text;
    
    public function rules() {
        return [
            [['name', 'email', 'text'], 'required'],
            ['email', 'email'],
        ];
    }
}

