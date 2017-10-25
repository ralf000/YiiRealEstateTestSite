<?php

use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= \common\components\UserComponent::getUserImage(Yii::$app->user->id) ?>" class="img-circle"
                     alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php
        $items = [
            '<li class="header">Menu Yii2</li>',
            ['label' => '<span class="fa fa-file-code-o"></span> Users', 'url' => ['/user']],
            ['label' => '<span class="fa fa-file-code-o"></span> Adverts', 'url' => ['/advert']],
            ['label' => '<span class="fa fa-file-code-o"></span> Gii', 'url' => ['/gii']],
            ['label' => '<span class="fa fa-dashboard"></span> Debug', 'url' => ['/debug']],
            ['label' => '<span class="fa fa-dashboard"></span> test', 'url' => ['/site/test']],
            ['label' => '<span class="fa fa-dashboard"></span> Roles', 'url' => ['/auth-item/index']],
        ];
        if (Yii::$app->user->can('can manage users')){
            $items = ArrayHelper::merge($items, [['label' => '<span class="fa fa-dashboard"></span> Users', 'url' => ['/user/index']]]);
        }
        if (Yii::$app->user->isGuest){
            $items = ArrayHelper::merge($items, [
                [
                    'label' => '<span class="glyphicon glyphicon-lock"></span> Sing in', //for basic
                    'url' => ['/site/login'],
                    'visible' =>Yii::$app->user->isGuest
                ],
            ]);
        }
        ?>
        <?= Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
            ]
        );
        ?>

    </section>

</aside>
