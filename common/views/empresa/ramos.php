<?php 

use common\models\TemplateHijo;
use kartik\widgets\SwitchInput;

use common\assets\ViewAsset;
use common\models\Ramo;

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
                            foreach($Ramos as $Ramo):
                                ?>


                                    <tr>
                                    <td width="20%"><?php echo $Ramo->nombre ?></td>

                                    <td class="text-sm-center text-info">

                                        <?php
                                        // consulto si este subRon ya está asignado al rol principal
                                        // para ver si tiene que aparecer tikeado

                                        if(Ramo::getConfirnarCargadosEmpresa($model->id,$Ramo->id)){


                                            echo SwitchInput::widget(['name'=>'Empresa_'.$Ramo->id, 'value'=>true]);
                                        }else{

                                            echo SwitchInput::widget(['name'=>'Empresa_'.$Ramo->id, 'value'=>false,]);
                                        }

                                        

                                        $texto_script .= "

                                        $('input[name=\"Empresa_" . $Ramo->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                            var _url;
                                            _url='assign-ramo';
                                            $.ajax({
                                                url: _url,
                                                data: {Ramoid:'" . $Ramo->id . "',Ramoname:'" . $Ramo->nombre . "',empresaid:'" . $model->id . "',empresaname:'" . $model->nombre . "'},
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