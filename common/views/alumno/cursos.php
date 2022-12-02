<?php

use common\models\UsuarioCurso;
use kartik\widgets\SwitchInput;

$texto_script = "";


?>

    <div class="card">
        <div class="card-header">
        <i class="icon-check"></i>Asignar Curso
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
                        foreach($cursos as $curso):
                            ?>

                            <tr>
                            <td><?php echo $curso->nombre ?></td>
                            <td><?php echo $curso->descripcion ?></td>

                            <td class="text-sm-center text-info">

                                <?php
                                // consulto si este subRon ya está asignado al rol principal
                                // para ver si tiene que aparecer tikeado

                                if(UsuarioCurso::getConfirnarCurso($curso->id,$model->id)){


                                    echo SwitchInput::widget(['name'=>'curso_'.$curso->id, 'value'=>true]);
                                }else{

                                    echo SwitchInput::widget(['name'=>'curso_'.$curso->id, 'value'=>false,]);
                                }


                                $texto_script .= "

                                    $('input[name=\"curso_" . $curso->id . "\"]').on('switchChange.bootstrapSwitch', function(e, s) {
                                    //  console.log(e.target.value); // true | false
                                    var _url;
                                    _url='assign-curso';
                                    $.ajax({
                                        url: _url,
                                        
                                        data: {Cursoid:'" . $curso->id ."',userid:'".$model->id."'},
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