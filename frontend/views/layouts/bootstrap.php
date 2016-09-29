<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

\frontend\assets\MainAsset::register($this);//this - это ссылка на объект типа view
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$this->title ?></title>
<meta charset="UTF-8" />
 <meta charset="<?= \Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <?= Html::csrfMetaTags() ?><!--защита от атак-->
<?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<? if(\Yii::$app->session->hasFlash('success')):?>

<?=Yii::$app->session->getFlash('success')?>   
    

<? endif;?>
    
<!-- Header start-->
<?=$this->render('//common/head')?><!--этот рендер не такой как в контроллере а от класса views (двойной слеш это сокращение пути наших базовых шаблонов)-->
<!-- #Header end -->
<!--Content start-->
<?=$content?>
<!--Content end-->



<!--Footer start-->
<?=$this->render('//common/footer')?>
<!--Footer end-->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>