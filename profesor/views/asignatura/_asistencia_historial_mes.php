<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Ramo;
use common\models\Asistencia;
use kartik\widgets\FileInput;
use common\models\PruebaCategoria;

?>
    <div class="fondo-form">
        <div class="materiales-form">
            <?php $form = ActiveForm::begin(
                    [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                    ]
                    
                ); 
            $template = ' <div class="input-group tipotablacontenidoplaceholder">


                        {input}
                    </div>';// falta {hint}\n{error}
                $inputSize = '20';


            
            ?>  

        <div class="card">


            <div class="card-headermorado content-center">

                <div class="row">

                    <div class="col-md-10">
                        <h5> Historial de Asistencia</h5>
                    </div>

                </div>

            </div>
            
            <div class="card-body">

        
                <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

                <?=  $form->field($model, 'mes',['template' => $template])->widget(Select2::classname(), [
                        'data' =>Asistencia::getMeses(),
                        'language' => 'es',
                        'value' => 'red', // initial value
                        'options' => ['placeholder' => 'Seleccione Mes', 'id'=>'id_mes'],
                        'pluginOptions' => [
                            'placeholder' => 'Seleccione Mes',
                        ],
                    ]);

                $getTitoloDetalleMes = Asistencia::getTitoloDetalleMes(date('n'));



                    
                ?>


                <div id="resultado_ajax">

                    <?= $this->render('_asistencia_historial_tabla', [
                        'model' => $model,
                        'Alumnos' => $Alumnos,
                        'nombre_mes' => $getTitoloDetalleMes['nombre'],
                        'MallaHorariaProfesor' => $MallaHorariaProfesor,

                    ]) ?> 

                </div>


                
            </div>

            <div class="card-footer ">

                <?= Html::a('Volver', ['/asignatura','id' => $MallaHorariaProfesor["id"],'fecha' => $fecha], ['class' => 'btn btn-success']);?>

            </div>

            <?php ActiveForm::end(); ?>
    


        </div>

    </div>
</div>

<?php 
$this->registerJs("
    $(\"#id_mes\").change(function(e) {
        var _url;

        var combo_mes = $(this);

        var resultado_ajax = $(\"#resultado_ajax\");

        _url='historial-asistencia-tabla';
        $.ajax({
            url: _url,
            data: {'id':" . $MallaHorariaProfesor['id'] . ",'mes':$(\"#id_mes\").val()},
            'dataType':'html',
            'type':'GET',
            'success':function(response)
            {
                
                resultado_ajax.html('');
                resultado_ajax.fadeOut().empty();
                resultado_ajax.append(response).fadeIn();


            } 
        });
    });


");
?>