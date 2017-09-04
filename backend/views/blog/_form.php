<?php

use common\models\Blog;
use common\models\Tag;
use kartik\file\FileInput;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <!--    --><? //= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => Url::to(['/blog/save-img'])
        ]
    ]); ?>

    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' => 'Выберите изображение'
        ],
        'options' => ['accept' => 'image/*']
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList(Blog::STATUSES) ?>

    <?= $form->field($model, 'tags_array')->widget(Select2::className(), [
        'name' => 'tags_array',
        'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Выберите тег...', 'multiple' => true],
        'maintainOrder' => true,
        'toggleAllSettings' => [
            'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> Tag All',
            'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> Untag All',
            'selectOptions' => ['class' => 'text-success'],
            'unselectOptions' => ['class' => 'text-danger'],
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 100
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
