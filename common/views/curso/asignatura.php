<?php 

use kartik\widgets\SwitchInput;

use common\models\SubRamo;
use yii\helpers\ArrayHelper;


 ?>

<?php

$Ramos = ArrayHelper::index($Ramos,null, 'id_ramo');

$texto_script = "";

foreach ($Ramos as $key => $Ramo) {

    ?>

        <div class="card">
            <div class="card-header">
                <i class="icon-check"></i>Asignar Ramos <?php echo $Ramo[0]['ramo_nombre'] ?>
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
                                    
                                    // Recorro los subRoles
                                    foreach($Ramo as $Ram):


                                        ?>


                                            <tr>
                                            <td width="20%"><?php echo $Ram['sub_ramo_nombre'] ?></td>

                                            <td class="text-sm-center text-info">

                                                <?php
                                                // consulto si este subRon ya está asignado al rol principal
                                                // para ver si tiene que aparecer tikeado

                                                if(SubRamo::getConfirnarCargadosAsignatura($model->id,$Ram['id_sub_ramo'])){

                                                    echo SwitchInput::widget(['name'=>'Sub_Ramo_Empresa_'.$Ram['id_sub_ramo'], 'value'=>true]);

                                                }else{

                                                    echo SwitchInput::widget(['name'=>'Sub_Ramo_Empresa_'.$Ram['id_sub_ramo'], 'value'=>false,]);

                                                }

                                                

                                                $texto_script .= "

                                                $('input[name=\"Sub_Ramo_Empresa_" . $Ram['id_sub_ramo'] . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                                    var _url;
                                                    _url='assign-sub-ramo';
                                                    $.ajax({
                                                        url: _url,
                                                        data: {SubRamoid:'" . $Ram['id_sub_ramo'] . "',SubRamoNombre:'" . $Ram['sub_ramo_nombre'] . "',CursoId:'" . $model->id . "',CursoNombre:'" . $model->nombre . "'},
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

$this->registerJs($texto_script); 

?>