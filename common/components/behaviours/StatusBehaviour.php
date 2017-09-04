<?php

namespace common\components\behaviours;


use common\models\Blog;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class StatusBehaviour extends Behavior
{
    public function events()
    {
      return [
          ActiveRecord::EVENT_AFTER_FIND => 'changeTitle'
      ];
    }

    public function changeTitle()
    {
        $this->owner->title .= ' ' . Blog::STATUSES[$this->owner->status];
    }
}