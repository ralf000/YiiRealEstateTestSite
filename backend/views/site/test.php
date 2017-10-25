<?php

use common\models\Blog;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php if (Yii::$app->user->can('can create notes of blog')): ?>
    <?= \yii\helpers\Html::a('Новая запись', Url::toRoute(['blog/create']), ['class' => 'btn btn-primary pull-right']) ?>
<?php endif; ?>
<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 20000
]) ?>
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
            'format' => 'datetime',
            'value' => 'created_at',
            'filter' => \kartik\datecontrol\DateControl::widget([
                'model' => $blogSearch,
                'attribute' => 'created_at',
                'saveFormat' => 'php:U'
            ])
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'value' => 'created_at',
            'filter' => \kartik\daterange\DateRangePicker::widget([
                'name' => 'created_at',
            ])
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
<?php Pjax::end() ?>

<div id="loading" style="display: none;"><img
            src="https://ea69e954660a5bfe03d0-eb6d7e0fbdb68b2cf5905bd4f8f28c48.ssl.cf5.rackcdn.com/stowify_resources/images/loading4_old.gif"
            alt=""></div>
<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 20000
]) ?>
<a id="link" href="<?= Url::to('/site/testlink') ?>" class="btn btn-lg btn-danger">Тестовая ссылка</a>
<?php Pjax::end() ?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$js = <<<JS
$(document).on('pjax:send', function() {
  $('#loading').show()
});
$(document).on('pjax:complete', function() {
  $('#loading').hide()
});
$('a[href*=update]').on('click', function(e) {
  e.preventDefault();
  $('.fa-spin').fadeIn();
  var href = $(this).attr('href');
  var pos = href.indexOf('id=');
  var id = $(this).attr('href').substr(pos + 3);
  var modal = $('#modal-default');
  $('body').append('')
  modal.find('.modal-body').load('/blog/update?id='+id, function(responce, status) {
    if (status == 'success'){
        $('.fa-spin').fadeOut();
        modal.modal('show');
    }
  });
})
JS;
/** @var \yii\web\View $this */
$this->registerJs($js, \yii\web\View::POS_END);
?>
