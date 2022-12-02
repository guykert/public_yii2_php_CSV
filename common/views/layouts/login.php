<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\assets\LoginAsset;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

// AppAsset::register($this);
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=$this->assetBundles['backend\assets\LoginAsset']->baseUrl?>/img/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=$this->assetBundles['backend\assets\LoginAsset']->baseUrl?>/img/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=$this->assetBundles['backend\assets\LoginAsset']->baseUrl?>/img/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?=$this->assetBundles['backend\assets\LoginAsset']->baseUrl?>/img/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?=$this->assetBundles['backend\assets\LoginAsset']->baseUrl?>/img/favicon.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="bodyjmora default-translucent-bg">

    <?php $this->beginBody() ?>
<!--     <section>
        <header>
            <div class="container">
                <div class="logo"></div>
            </div>
        </header>
    </section> -->

    <div class="wrap">


        <div class="container">

        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <!-- <footer class="footer">
            <div class="">
            <div class="container">
                    <div class="col-xs-12 col-md-12">
                        <div class="col-xs-6 col-md-6 alineartextopie1">&nbspcontacto@pedrodevaldivia.cl</div>
                        <div class="col-md-2 alineartextopie2"><div class="logopdv"></div></div><div>

                    </div> -->
                <!-- <div class="container">
                    <div class="col-md-12">
                        <div class="col-md-6 alineartextopie1">&copy; Preuniversitario Pedro de Valdivia. Todos los derechos reservados <?php echo date('Y'); ?>.</div>
                        <div class="col-md-2 alineartextopie2"> &nbspcontacto@pedrodevaldivia.cl</div>
                        <div class="col-md-4 alineartextopie3"><div class="logoonline"></div></div>
                    </div>
                </div>
            </div>
        </footer>

   <!--  <?php $this->endBody() ?> -->
</body>
</html>
<?php $this->endPage() ?>
