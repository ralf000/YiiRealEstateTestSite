<?php $this->beginContent('@app/views/layouts/bootstrap.php'); //наследует главный шаблон?>
    <div class="container">
    <?=$content ?>
    </div>
<?php $this->endContent(); ?>