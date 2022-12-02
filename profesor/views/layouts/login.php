<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\assets\LoginAlumnoAsset;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

// AppAsset::register($this);
LoginAlumnoAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SimpliQ Bootstrap 4 Admin Template">
  <meta name="author" content="Lukasz Holeczek">
  <meta name="keyword" content="SimpliQ Bootstrap 4 Admin Template">
  <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>

<body class="ImgFondo app flex-row align-items-center ImgFondo">
  <?php $this->beginBody() ?>
    <div class="container">

      <?= Alert::widget() ?>
      <?= $content ?>
      

    </div>

  <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
