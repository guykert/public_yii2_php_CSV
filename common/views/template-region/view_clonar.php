<?php


use yii\widgets\DetailView;

echo  DetailView::widget([
    'options'=>[
        'class' => 'table colortabalfondo table-bordered detail-view'
    ],
    'model' => $model,
    'attributes' => [
    
        'id',
        'template_id',
        'tipo_elemento_id',
        'nombre',
        'descripcion',
        'respuesta',
        'x',
        'y',
        'width',
        'height',

    ],
]) ?>




