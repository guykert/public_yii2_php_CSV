<?php 

use common\models\Rol;
use kartik\widgets\SwitchInput;

use common\assets\ViewAsset;


ViewAsset::register($this);

 ?>

<div class="card">
    <div class="card-header">
        <i class="icon-check"></i>Asignar Roles
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
                            $texto_script = "";
                            // Recorro los subRoles
                            foreach($Roles as $Rol):
                                ?>


                                    <tr>
                                    <td width="20%"><?php echo $Rol->name ?></td>
                                    <td width="70%"><?php echo $Rol->description ?></td>

                                    <td class="text-sm-center text-info">

                                        <?php
                                        // consulto si este subRon ya está asignado al rol principal
                                        // para ver si tiene que aparecer tikeado

                                        if(Rol::getConfirnarAsignados($model->id,$Rol->name)){
                                            
                                            
                                            echo SwitchInput::widget(['name'=>'Rol_'.$Rol->id, 'value'=>true]);
                                        }else{
                                            
                                            echo SwitchInput::widget(['name'=>'Rol_'.$Rol->id, 'value'=>false,]);
                                        }

                                        

                                        $texto_script .= "

                                        $('input[name=\"Rol_" . $Rol->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                            var _url;
                                            _url='assign';
                                            $.ajax({
                                                url: _url,
                                                data: {Rolid:'" . $Rol->id . "',Rolname:'" . $Rol->name . "',userid:'" . $model->id . "',username:'" . $model->nombre . "'},
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

    if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador')){
    
        ?>

            <div class="card">
                <div class="card-header">
                    <i class="icon-check"></i>Asignar Permisos
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

                                        // Recorro los subRoles
                                        foreach($subRoles as $subRol):
                                            ?>


                                                <tr>
                                                <td width="20%"><?php echo $subRol->name ?></td>
                                                <td width="70%"><?php echo $subRol->description ?></td>

                                                <td class="text-sm-center text-info">

                                                    <?php
                                                        // consulto si este subRon ya está asignado al rol principal
                                                        // para ver si tiene que aparecer tikeado

                                                        if(Rol::getConfirnarAsignados($model->id,$subRol->name)){
                                                            
                                                            
                                                            echo SwitchInput::widget(['name'=>'Rol_'.$subRol->id, 'value'=>true]);
                                                        }else{
                                                            
                                                            echo SwitchInput::widget(['name'=>'Rol_'.$subRol->id, 'value'=>false,]);
                                                        }

                                                        $texto_script .= "

                                                        $('input[name=\"Rol_" . $subRol->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {

                                                            var _url;
                                                            _url='assignpermiso';
                                                            $.ajax({
                                                                url: _url,
                                                                data: {Rolid:'" . $subRol->id . "',Rolname:'" . $subRol->name . "',userid:'" . $model->id . "',username:'" . $model->nombre . "'},
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