<?php 

use common\models\TemplateHijo;
use kartik\widgets\SwitchInput;

use common\assets\ViewAsset;
use common\models\PruebaCategoriaHijo;


ViewAsset::register($this);

 ?>

<div class="card">
    <div class="card-header">
        <i class="icon-check"></i>Asignar Categorías de pruebas
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
                            foreach($PruebaCategoria as $PruebaCat):
                                ?>


                                    <tr>
                                    <td width="20%"><?php echo $PruebaCat->nombre ?></td>

                                    <td class="text-sm-center text-info">

                                        <?php
                                        // consulto si este subRon ya está asignado al rol principal
                                        // para ver si tiene que aparecer tikeado

                                        if(PruebaCategoriaHijo::getConfirnarAsignados($model->id,$PruebaCat->id)){
                                            
                                            
                                            echo SwitchInput::widget(['name'=>'Temp_'.$PruebaCat->id, 'value'=>true]);
                                        }else{
                                            
                                            echo SwitchInput::widget(['name'=>'Temp_'.$PruebaCat->id, 'value'=>false,]);
                                        }

                                        

                                        $texto_script .= "

                                        $('input[name=\"Temp_" . $PruebaCat->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                            var _url;
                                            _url='assign-categoria';
                                            $.ajax({
                                                url: _url,
                                                data: {Categoriaid:'" . $PruebaCat->id . "',Categorianame:'" . $PruebaCat->nombre . "',userid:'" . $model->id . "',username:'" . $model->nombre . "'},
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