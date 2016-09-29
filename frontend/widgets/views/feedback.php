<div class="enquiry">
<h6><span class="glyphicon glyphicon-envelope"></span> Post Enquiry</h6>
<?
 $form = \yii\bootstrap\ActiveForm::begin();
?>
<?= $form->field($model, 'email')->textInput(['value' => $current_user['email'], 'placeholder' => 'you@yourdomain.com'])->label(false) ?>
<?= $form->field($model, 'name')->textInput(['value' => $current_user['username'], 'placeholder' => 'Username'])->label(false) ?>
<?= $form->field($model, 'text')->textarea(['rows' => 6, 'placeholder' => 'Whats on your mind?'])->label(false) ?>
<button type="submit" class="btn btn-primary" name="Submit">Send Message</button>

<?
 \yii\bootstrap\ActiveForm::end();
?>
</div>