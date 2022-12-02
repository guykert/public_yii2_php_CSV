<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
use common\models\Ramo;
use kartik\widgets\SwitchInput;

MantenedoresAsset::register($this);

$texto_script = "";

/* @var $this yii\web\View */
/* @var $model common\models\Ramo */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Ramos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
?>


<main class="main">
        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',

    ]) ?>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="alineadototal">

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  Ver información del id</div>
                            <div>

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>

                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el idate

                            <div class="espacio-chico"></div>


                            <?= DetailView::widget([
                                'options'=>[
                                    'class' => 'table colortabalfondo table-bordered detail-view'
                                ],
                                'model' => $model,
                                'attributes' => [

                                    'nombre',
                                    'descripcion',

                                    'codigo',
                                    // 'division_menciones',
                          ],
                            ]) ?>


                                        <div class="card">
                                            <div class="card-header">
                                            <i class="icon-check"></i>Asignar Empresa
                                            <ul class="nav nav-tabs float-right" role="tablist">

                                            </ul>
                                            </div>
                                            <div class="card-body p-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tasks">
                                                <table class="table table-hover table-align-middle mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th class="text-sm-center">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                            // Recorro los Empresas
                                                            foreach($Empresas as $Empresa):
                                                                ?>

                                                                <tr>
                                                                <td><?php echo $Empresa->nombre ?></td>
                                                                <td><?php echo $Empresa->descripcion ?></td>
            
                                                                <td class="text-sm-center text-info">

                                                                    <?php
                                                                    // consulto si este subRon ya está asignado al rol principal
                                                                    // para ver si tiene que aparecer tikeado

                                                                    if(Ramo::getConfirnarCargados($model->id,$Empresa->id)){


                                                                        echo SwitchInput::widget(['name'=>'Empresa_'.$Empresa->id, 'value'=>true]);
                                                                    }else{

                                                                        echo SwitchInput::widget(['name'=>'Empresa_'.$Empresa->id, 'value'=>false,]);
                                                                    }


                                                                    $texto_script .= "

                                                                        $('input[name=\"Empresa_" . $Empresa->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                                                        //  console.log(e.target.value); // true | false
                                                                        var _url;
                                                                        _url='assign';
                                                                        $.ajax({
                                                                            url: _url,
                                                                           
                                                                            data: {padreid:'" . $model->id ."',padrename:'".$model->nombre."',hijoid:'". $Empresa->id . "',hijoname:'" . $Empresa->nombre .  "'},
                                                                            'dataType':'json',
                                                                            'type':'GET',
                                                                            'success':function(data)
                                                                            {
                                                                                return true;

                                                                            } ,
                                                                            'cache':false});
                                                                            return false;

                                                                        });

                                                                    ";
                                                                    ?>

                                                                </td>
                                                                </tr>

                                                                <?php

                                                            endforeach;

                                                        ?>

                                                    </tbody>
                                                </table>
                                                </div>

                                            </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                            <i class="icon-check"></i>Asignar Corporación
                                            <ul class="nav nav-tabs float-right" role="tablist">

                                            </ul>
                                            </div>
                                            <div class="card-body p-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tasks">
                                                <table class="table table-hover table-align-middle mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th class="text-sm-center">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                            // Recorro los Empresas
                                                            foreach($Corporaciones as $Corporacion):
                                                                ?>

                                                                <tr>
                                                                <td><?php echo $Corporacion->nombre ?></td>
                                                                <td><?php echo $Corporacion->descripcion ?></td>
            
                                                                <td class="text-sm-center text-info">

                                                                    <?php
                                                                    // consulto si este subRon ya está asignado al rol principal
                                                                    // para ver si tiene que aparecer tikeado

                                                                    if(Ramo::getConfirnarCargados($model->id,$Corporacion->id)){


                                                                        echo SwitchInput::widget(['name'=>'Corporacion_'.$Corporacion->id, 'value'=>true]);
                                                                    }else{

                                                                        echo SwitchInput::widget(['name'=>'Corporacion_'.$Corporacion->id, 'value'=>false,]);
                                                                    }


                                                                    $texto_script .= "

                                                                        $('input[name=\"Corporacion_" . $Corporacion->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                                                        //  console.log(e.target.value); // true | false
                                                                        var _url;
                                                                        _url='assign';
                                                                        $.ajax({
                                                                            url: _url,
                                                                           
                                                                            data: {padreid:'" . $model->id ."',padrename:'".$model->nombre."',hijoid:'". $Corporacion->id . "',hijoname:'" . $Corporacion->nombre .  "'},
                                                                            'dataType':'json',
                                                                            'type':'GET',
                                                                            'success':function(data)
                                                                            {
                                                                                return true;

                                                                            } ,
                                                                            'cache':false});
                                                                            return false;

                                                                        });

                                                                    ";
                                                                    ?>

                                                                </td>
                                                                </tr>

                                                                <?php

                                                            endforeach;

                                                        ?>

                                                    </tbody>
                                                </table>
                                                </div>

                                            </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                            <i class="icon-check"></i>Asignar Colegio
                                            <ul class="nav nav-tabs float-right" role="tablist">

                                            </ul>
                                            </div>
                                            <div class="card-body p-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tasks">
                                                <table class="table table-hover table-align-middle mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th class="text-sm-center">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                            // Recorro los Empresas
                                                            foreach($Colegios as $Colegio):
                                                                ?>

                                                                <tr>
                                                                <td><?php echo $Colegio->nombre ?></td>
                                                                <td><?php echo $Colegio->descripcion ?> </td>
            
                                                                <td class="text-sm-center text-info">

                                                                    <?php
                                                                    // consulto si este subRon ya está asignado al rol principal
                                                                    // para ver si tiene que aparecer tikeado

                                                                    if(Ramo::getConfirnarCargados($model->id,$Colegio->id)){


                                                                        echo SwitchInput::widget(['name'=>'Colegio_'.$Colegio->id, 'value'=>true]);
                                                                    }else{

                                                                        echo SwitchInput::widget(['name'=>'Colegio_'.$Colegio->id, 'value'=>false,]);
                                                                    }


                                                                    $texto_script .= "

                                                                        $('input[name=\"Colegio_" . $Colegio->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                                                        //  console.log(e.target.value); // true | false
                                                                        var _url;
                                                                        _url='assign';
                                                                        $.ajax({
                                                                            url: _url,
                                                                            data: {padreid:'" . $model->id ."',padrename:'".$model->nombre."',hijoid:'". $Colegio->id . "',hijoname:'" . $Colegio->nombre .  "'},
                                                                            'dataType':'json',
                                                                            'type':'GET',
                                                                            'success':function(data)
                                                                            {
                                                                                return true;

                                                                            } ,
                                                                            'cache':false});
                                                                            return false;

                                                                        });

                                                                    ";
                                                                    ?>

                                                                </td>
                                                                </tr>

                                                                <?php

                                                            endforeach;

                                                        ?>

                                                    </tbody>
                                                </table>
                                                </div>

                                            </div>
                                            </div>
                                        </div>



                        </div>

                        <div class="card-footer">



                        </div>
                        
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>


<?=ercling\pace\PaceWidget::widget([
    'color'=>'red',
    'theme'=>'corner-indicator',

    'options'=>[
        'ajax'=>['trackMethods'=>['GET','POST']],

    ]
])?>

<?php

$this->registerJs($texto_script);

?>



</main>


