<?php 

use common\models\TemplateHijo;
use kartik\widgets\SwitchInput;

use common\assets\ViewAsset;
use common\models\SubRamo;

ViewAsset::register($this);

 ?>

<div class="card">
    <div class="card-header">
        <i class="icon-check"></i>Asignar Ramos
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
                            <th class="text-sm-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $texto_script = "";
                            // Recorro los subRoles
                            foreach($SubRamos as $subRamo):


                                ?>


                                    <tr>
                                    <td width="20%"><?php echo $subRamo->nombre ?></td>

                                    <td class="text-sm-center text-info">

                                        <?php
                                        // consulto si este subRon ya está asignado al rol principal
                                        // para ver si tiene que aparecer tikeado

                                        if(SubRamo::getConfirnarCargadosEmpresa($model->id,$subRamo->id)){


                                            echo SwitchInput::widget(['name'=>'Sub_Ramo_Empresa_'.$subRamo->id, 'value'=>true]);
                                        }else{

                                            echo SwitchInput::widget(['name'=>'Sub_Ramo_Empresa_'.$subRamo->id, 'value'=>false,]);
                                        }

                                        

                                        $texto_script .= "

                                        $('input[name=\"Sub_Ramo_Empresa_" . $subRamo->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                            var _url;
                                            _url='assign-sub-ramo';
                                            $.ajax({
                                                url: _url,
                                                data: {subRamoid:'" . $subRamo->id . "',subRamoname:'" . $subRamo->nombre . "',empresaid:'" . $model->id . "',empresaname:'" . $model->nombre . "'},
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