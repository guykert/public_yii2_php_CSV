<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contacto */

$this->title = 'Update Contacto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contacto-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
