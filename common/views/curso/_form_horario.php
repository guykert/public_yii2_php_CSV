<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\TimePicker;
// use kartik\checkbox\CheckboxX;
use kartik\icons\Icon;
use kartik\field\FieldRange;
use kartik\widgets\Select2;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use common\models\Dia;
use common\models\MallaHorariaCurso;
use common\models\CursoAsignatura;

/* @var $this yii\web\View */
/* @var $model backend\models\Dia */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/

$MallaHorariaCurso = MallaHorariaCurso::findOne($id);

?>


        <?php $form = ActiveForm::begin(
                        [
                        	'id'=>'id_form_'.$id,
                            'enableAjaxValidation' => true,

                        ]
		); 
		
		$template =    '<div class="form-group">
				<label class="col-form-label" for="firstname">{label}</label>
				{input}
			</div>';// falta {hint}\n{error}



		
		?>


        <?= $form->errorSummary($MallaHorariaCurso) ?> <!-- ADDED HERE -->

				<?=  $form->field($MallaHorariaCurso, '['.$id.']dia_id',['template' => $template])->widget(Select2::classname(), [
					'data' => Dia::getDiaCombo(),
					'language' => 'es',
					'value' => 'red', // initial value
					'disabled' => true,
					'options' => ['placeholder' => 'Seleccione Día'],
					'pluginOptions' => [
						'allowClear' => true,

					],
				]);?> 

				<?=  $form->field($MallaHorariaCurso, '['.$id.']asignatura_id',['template' => $template])->widget(Select2::classname(), [
					'data' => CursoAsignatura::getAsignaturasCursoCombo($model->id),
					'language' => 'es',
					'value' => 'red', // initial value
					'options' => ['placeholder' => 'Seleccione Asignatura'],
					'disabled' => true,
					'pluginOptions' => [
						'allowClear' => true,

					],
                ]);?> 

	            <?= '<label>Hora Desde</label>'  ?>
	            <?= TimePicker::widget([
						'name' => 'hora_desde',
						'id' => 'hora_desde_timepicker_',
						'disabled' => true,
						'value' => $hora_desde,
					    'pluginOptions' => [
					        'showMeridian' => false,
					    ]
					]); 
				?>
	                <?= '<label>Hora Hasta</label>'  ?>
	            <?= TimePicker::widget([
	            		'name' => 'hora_hasta',
	            		'id' => 'hora_hasta_timepicker_',
	            		'disabled' => true,
	            		'value' => $hora_hasta,
					    'pluginOptions' => [
					        'showMeridian' => false,
					    ]
	            	]); ?>
	                <br>


	             <br>

	             <br>
	             <?php  //echo Html::submitButton(Icon::show('save', [], Icon::BSG), ['class'=>'btn btn-default kv-editable-submit']); ?>


				<?php 

					echo Html::a('

					<i class="fa fa-trash"></i>

					', ['eliminar-horario-curso','curso_id'=>$model->id,'horario_curso_id'=>$id,'confirma'=>'si'], ['class'=>'btn btn-default kv-editable-reset','data-confirm'=>'¿Estás seguro que quieres eliminar este horario ?']);

				?>


        <?php ActiveForm::end(); ?>

