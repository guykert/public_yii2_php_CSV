<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Contacto */

$this->title = 'Create Contacto';
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacto-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
