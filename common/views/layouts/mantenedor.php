<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;


use common\widgets\Alert;

$directoryAsset = "";

$menuItems=[];



use common\assets\MantenedoresAsset;



if (Yii::$app->user->identity->anio_predeterminado > 0) {
    // if (Yii::$app->user->identity->anio->anio_academico == date('Y')) {
        MantenedoresAsset::register($this);
        $rutaAsset = $this->assetBundles['common\assets\MantenedoresAsset']->baseUrl."/img/";
    // }else{
    //     MantenedoresAssetOtroAnio::register($this);
    //     $rutaAsset = $this->assetBundles['common\assets\MantenedoresAssetOtroAnio']->baseUrl."/img/OtroAnio/";
    // }
}else{
    MantenedoresAsset::register($this);
    $rutaAsset = $this->assetBundles['common\assets\MantenedoresAsset']->baseUrl."/img/";
}

MantenedoresAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SimpliQ - Bootstrap 4 Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,jQuery,CSS,HTML,RWD,Dashboard,Vue,Vue.js,React,React.js">
    <link rel="shortcut icon" href="<?=$rutaAsset?>favicon.png">
    <title>Desarrollos tecnológicos .CSV</title>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'                  - Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'                 - Fixed Sidebar
2. '.sidebar-hidden'                - Hidden Sidebar
3. '.sidebar-off-canvas'        - Off Canvas Sidebar
4. '.sidebar-minimized'         - Minimized Sidebar (Only icons)
5. '.sidebar-compact'             - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'          - Fixed Aside Menu
2. '.aside-menu-hidden'         - Hidden Aside Menu
3. '.aside-menu-off-canvas' - Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'          - Fixed Breadcrumb

// Footer options
1. '.footer-fixed'                  - Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <?php $this->beginBody() ?>


        <?= $this->render(
            'menu_superior.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <div class="app-body">


        <?= $this->render(
            'menu_izquierdo.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>


        <?= $content ?>

        <?= $this->render(
            'menu_derecho.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        </div>

        <?= $this->render(
            'footer.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>


    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
