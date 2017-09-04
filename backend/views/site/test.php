<?php

use common\models\Blog;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<?= \yii\helpers\Html::a('Новая запись', Url::toRoute(['blog/create']), ['class' => 'btn btn-primary pull-right']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $blogSearch,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::className()],
        [
            'attribute' => 'id',
            'filter' => false
        ],
        'title',
        'description',
        'thumbnail:image',
        [
            'attribute' => 'author',
            'value' => function (Blog $model) {
                return $model->author->username;
            },
            'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'username', 'username')
        ],
        [
            'attribute' => 'tags',
            'value' => function (Blog $model) {
                $output = '';
                foreach ($model->tags as $tag) {
                    $output .= '<li>' . $tag->title . '</li>';
                }
                return '<ul>' . $output . '</ul>';
            },
            'format' => 'raw',
            'filter' => ArrayHelper::map(\common\models\Tag::find()->asArray()->all(), 'id', 'title')
        ],
        [
            'attribute' => 'status',
            'value' => function (Blog $model) {
                return Blog::STATUSES[$model->status];
            },
            'filter' => Blog::STATUSES
        ],
        [
            'attribute' => 'created_at',
            'value' => function (Blog $model) {
                return date('H:i:s d-m-Y', $model->created_at);
            },
            'filter' => false
        ],
        [
            'attribute' => 'updated_at',
            'value' => function (Blog $model) {
                return date('H:i:s d-m-Y', $model->updated_at);
            },
            'filter' => false
        ],
        [
            'class' => \yii\grid\ActionColumn::className(),
            'buttons' => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a('Посмотреть', Url::toRoute(['blog/view', 'id' => $model->id]));
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a('Обновить', Url::toRoute(['blog/update', 'id' => $model->id]));
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a('Удалить', Url::toRoute(['blog/delete', 'id' => $model->id, 'data-method' => 'post']));
                }
            ]
        ]
    ]
]); ?>