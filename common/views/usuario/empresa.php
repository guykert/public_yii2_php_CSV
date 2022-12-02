<?php

use common\models\Usuario;
use kartik\widgets\SwitchInput;

$texto_script = "";

?>

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

                                if(Usuario::getConfirnarEmpresa($model->id,$Empresa->id)){


                                    echo SwitchInput::widget(['name'=>'Empresa_'.$Empresa->id, 'value'=>true]);
                                }else{

                                    echo SwitchInput::widget(['name'=>'Empresa_'.$Empresa->id, 'value'=>false,]);
                                }


                                $texto_script .= "

                                    $('input[name=\"Empresa_" . $Empresa->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                    //  console.log(e.target.value); // true | false
                                    var _url;
                                    _url='assign-empresa';
                                    $.ajax({
                                        url: _url,
                                        
                                        data: {usuarioid:'" . $model->id ."',empresaid:'". $Empresa->id . "'},
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

                                if(Usuario::getConfirnarEmpresa($model->id,$Corporacion->id)){


                                    echo SwitchInput::widget(['name'=>'Corporacion_'.$Corporacion->id, 'value'=>true]);
                                }else{

                                    echo SwitchInput::widget(['name'=>'Corporacion_'.$Corporacion->id, 'value'=>false,]);
                                }


                                $texto_script .= "

                                    $('input[name=\"Corporacion_" . $Corporacion->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                    //  console.log(e.target.value); // true | false
                                    var _url;
                                    _url='assign-empresa';
                                    $.ajax({
                                        url: _url,
                                        
                                        data: {usuarioid:'" . $model->id ."',empresaid:'". $Corporacion->id . "'},
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

                                if(Usuario::getConfirnarEmpresa($model->id,$Colegio->id)){


                                    echo SwitchInput::widget(['name'=>'Colegio_'.$Colegio->id, 'value'=>true]);
                                }else{

                                    echo SwitchInput::widget(['name'=>'Colegio_'.$Colegio->id, 'value'=>false,]);
                                }


                                $texto_script .= "

                                    $('input[name=\"Colegio_" . $Colegio->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                    //  console.log(e.target.value); // true | false
                                    var _url;
                                    _url='assign-empresa';
                                    $.ajax({
                                        url: _url,
                                        data: {usuarioid:'" . $model->id ."',empresaid:'". $Colegio->id . "'},
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

$this->registerJs($texto_script); 

?>