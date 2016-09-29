<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'User Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <table class="table table-striped table-bordered ">
        <? $user = \Yii::$app->user->identity;?>
        <tr><td width="20%">Ваш логин: </td><td><?=$user->username;?></td></tr>
        <tr><td width="20%">Ваш email: </td><td><?=$user->email;?></td></tr>
    </table>
    <a href="/site/request-password-reset" class="btn btn-warning" data-method="post">Сменить пароль</a>
    <a href="/site/logout" class="btn btn-danger" data-method="post">Выйти</a>

</div>