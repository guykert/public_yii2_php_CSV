<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Dia;
use common\models\MallaHorariaColegio;
use common\models\CursoAsignatura;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\TimePicker;



/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/
?>
<div class="container-fluid">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(
                    [
                    'id'=>'form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']

                    



                    ]
                    
                );  
                
                $template =    '<div class="form-group">
                    <label class="col-form-label" for="firstname">{label}</label>
                    {input}
                </div>';// falta {hint}\n{error}
                $inputSize = '60';
                ?>

                    <div class="card">
                        <div class="card-header">

                        </div>
                        
                        <div class="card-body">
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    
                                    <?=  $form->field($model, 'dia_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Dia::getDiaCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Día', 'id'=>'id_dia'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 



                                    <?= '<label>Hora Desde</label>'  ?>
                                    <?= TimePicker::widget([
                                            'name' => 'hora_desde',
                                            'id' => 'hora_desde_timepicker_',
                                            //'disabled' => true,
                                            'value' => $model->hora_desde,
                                            'pluginOptions' => [
                                                'showMeridian' => false,
                                            ]
                                        ]); 
                                    ?>
                                    
                                    <?= '<label>Hora Hasta</label>'  ?>
                                    <?= TimePicker::widget([
                                            'name' => 'hora_hasta',
                                            'id' => 'hora_hasta_timepicker_',
                                            //'disabled' => true,
                                            'value' => $model->hora_hasta,
                                            'pluginOptions' => [
                                                'showMeridian' => false,
                                            ]
                                        ]); ?>
                                    <br>

                                </div>

                                <div class="col-md-6">

                                    <?=  $form->field($model, 'asignatura_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => SubRamo::getSubRamoCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Asignatura', 'id'=>'id_curso'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 


                                    <?= $form->field($model, 'usar_bloques')->checkbox() ?>

                                    <?=  $form->field($model, 'malla_horaria_colegio_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => MallaHorariaColegio::getMallaCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Malla', 'id'=>'id_malla'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 


                                    

                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton($model->isNewRecord ? 'Crear <i class=\"iconomantenedor fa fa-plus\"></i>' : 'Modificar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>

<?php 
$texto_script = "

    $('.field-id_malla').hide();

    $('input[id=\"mallahorariacurso-usar_bloques\"]').change(function(e) {



        if($(this).val() == 1){
            
            $('.field-id_malla').show();

            $(this).val(0);
        
        }else{

            $('.field-id_malla').hide();

            $(this).val(1);
            
        }

    });

    function send()
    {
      

        alert('test');
        var data=$('#person-form-edit_person-form').serialize();
   
        alert(data);
        
   
        $.ajax({
            url: 'asistencia',
            data: data,
            dataType:'html',
            success: function(data) {
                alert(data);
            },error: function(data) { // if error occured
                alert('Error occured.please try again');
                alert(data);
           },
           

        });



   }




";

$this->registerJs($texto_script);

?>
