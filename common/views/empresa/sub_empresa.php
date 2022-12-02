<?php

use common\models\Empresa;
use kartik\widgets\SwitchInput;

$texto_script = "";

if($model->empresa_tipo_id == 1){

    ?>

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
                        <th>Permiso</th>
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

                                    if(Empresa::getConfirnarCargados($model->id,$Corporacion->id)){


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

    <?php

}

?>

<?php

if($model->empresa_tipo_id == 1 || $model->empresa_tipo_id == 2){

    ?>

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
                        <th>Permiso</th>
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

                                    if(Empresa::getConfirnarCargados($model->id,$Colegio->id)){


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


    <?php

}

?>

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