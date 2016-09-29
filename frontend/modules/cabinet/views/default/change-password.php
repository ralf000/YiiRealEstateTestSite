<div class="advert-form">

    <? $form = \yii\bootstrap\ActiveForm::begin(); ?>

    <?=$form->field($model,'password')->passwordInput() ?>
    <?=$form->field($model,'repassword')->passwordInput() ?>


    <?= \yii\helpers\Html::submitButton('Change password', ['class' => 'btn btn-primary']) ?>

    <? \yii\bootstrap\ActiveForm::end() ?>


    </div>