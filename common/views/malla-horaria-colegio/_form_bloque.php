<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
// use kartik\checkbox\CheckboxX;
use kartik\icons\Icon;
use kartik\field\FieldRange;

use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Dia */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/
?>

        <?php $form = ActiveForm::begin(
                        [
                        	'id'=>'id_form_'.$bloque.'_'.$dia,
                            'enableAjaxValidation' => true,

                        ]
        ); ?>


        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

	            <?= '<label>Hora Desde</label>'  ?>
	            <?= TimePicker::widget([
						'name' => 'hora_desde',
						'id' => 'hora_desde_timepicker_'.$bloque.'_'.$dia,
						//'disabled' => true,
						'value' => $hora_desde,
					    'pluginOptions' => [
					        'showMeridian' => false,
					    ]
					]); 
				?>
	                <?= '<label>Hora Hasta</label>'  ?>
	            <?= TimePicker::widget([
	            		'name' => 'hora_hasta',
	            		'id' => 'hora_hasta_timepicker_'.$bloque.'_'.$dia,
	            		//'disabled' => true,
	            		'value' => $hora_hasta,
					    'pluginOptions' => [
					        'showMeridian' => false,
					    ]
	            	]); ?>
	                <br>


	            <?php 
					echo CheckboxX::widget([
					    'name' => 'semana',
					    'id' => 'semana_CheckboxX_'.$bloque.'_'.$dia,
					    'value' => 0,
					    'initInputType' => CheckboxX::INPUT_CHECKBOX,
					    'autoLabel' => true,
					    'labelSettings' => [
					    	'threeState' => true,
					        'label' => '<label>Lunes a Viernes</label>',
					        'position' => CheckboxX::LABEL_LEFT
					    ]
					]); 



					echo CheckboxX::widget([
					    'name' => 'semana_sabado',
					    'value' => 0,
					    'id' => 'semana_sabado_CheckboxX_'.$bloque.'_'.$dia,
					    'initInputType' => CheckboxX::INPUT_CHECKBOX,

					    'autoLabel' => true,

					    'labelSettings' => [
					    	'threeState' => true,
					        'label' => '<label>Lunes a Sábado</label>',
					        'position' => CheckboxX::LABEL_LEFT
					    ]
					]); 



	             ?>
	             <br>
	             <input type="hidden" name="dia_id" value="<?php echo $dia; ?>"/>
	             <input type="hidden" name="bloque" value="<?php echo $bloque; ?>"/>
				 <input type="hidden" name="malla_horaria_id" value="<?php echo $model->id; ?>"/>
	             <br>
	             <?php echo Html::submitButton(Icon::show('save', [], Icon::BSG), ['class'=>'btn btn-default kv-editable-guardar']); ?>

	             <?php 
	             if($boton_limpiar == 1){
	             	echo Html::button(Icon::show('ban-circle', [], Icon::BSG), ['id' => 'boton_cerrar_'.$bloque.'_'.$dia,'class'=>'btn btn-default kv-editable-reset','style'=>'display: none']); 
	             }else{
	             	echo Html::button(Icon::show('ban-circle', [], Icon::BSG), ['id' => 'boton_cerrar_'.$bloque.'_'.$dia,'class'=>'btn btn-default kv-editable-reset']); 
	             }
	             ?>

        <?php ActiveForm::end(); ?>

