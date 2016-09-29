<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adverts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idadvert',
            'price',
            'address',
            ////первый вариант вывода имени пользователя по его айди, который по умолчанию выводится в fk_agent
//            [
//                'attribute' => 'fk_agent',
//                'value' => function($user){
//                    return \common\models\Advert::find()->one()->getUser()->one()->username;
//                }
//            ],
            //второй вариант
            [
                'attribute' => 'Fk agent',
                'value' => 'user.username',
            ],
            'bedroom',
             'livingroom',
             'parking',
             'kitchen',
            // 'general_image',
            // 'description:ntext',
//             'location',
            // 'hot',
            // 'sold',
            // 'type',
            // 'recommend',
             'created_at:date',
             'updated_at:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

