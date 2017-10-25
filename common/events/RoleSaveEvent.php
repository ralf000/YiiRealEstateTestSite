<?php
/**
 * Created by PhpStorm.
 * User: kudinov
 * Date: 27.09.2017
 * Time: 18:18
 */

namespace common\events;


use backend\models\AuthItem;
use backend\models\AuthItemChild;
use yii\base\Event;
use yii\rbac\Role;

class RoleSaveEvent extends Event
{
    const ROLE_SAVED_EVENT = 'role-saved-event';

    public static function test(Event $event)
    {
        /** @var AuthItem $authItem */
        $authItem = $event->data;
        if (!$authItem->inherits_roles){
            $authItem->inherits_roles = [];
        }
        AuthItemChild::deleteAll(['parent' => $authItem->name]);
        foreach ($authItem->inherits_roles as $role) {
            $model = new AuthItemChild();
            $model->parent = $authItem->name;
            $model->child = $role;
            $model->save();
        }
    }
}