<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MallaHorariaAsset;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;

MallaHorariaAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\MallaHorariaColegio */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Malla Horaria Colegios', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
?>


<main class="main">
        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',

    ]) ?>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="alineadototal">

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  Ver información del id</div>
                            <div>

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>
                            
                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el id    
                            <div class="espacio-chico"></div>


                            <?= DetailView::widget([
                                'options'=>[
                                    'class' => 'table colortabalfondo table-bordered detail-view'
                                ],
                                'model' => $model,
                                'attributes' => [
                                
                                    'nombre',
                                    'descripcion',

                                ],
                            ]) ?>


                        </div>

                        <div class="card-footer">


                            <div class="row">
                                <div class="col-xs-1 numerodebloque">
                                    <div class="col-xs-12">

                                    </div>
                                </div>
                                <div class="col-xs-11 sacarpadding">

                                    <?php 

                                        foreach ($dias as $key => $dia) {

                                            ?>

                                                <div class="col-xs-2 diasemana">

                                                    <div class="BotonSelecionadoFalsoAzul">

                                                        <?php echo $dia->nombre; ?>

                                                    </div>
                                                    
                                                </div>

                                            <?php 

                                        }

                                    ?>


                                </div>
                            </div>

                            <?php

                                foreach ($bloques as $key => $bloque) {
                                    ?>

                                        <div class="row">
                                            <div class="col-xs-1 numerodebloque">
                                                <div class="col-xs-12">
                                                    <?php echo $bloque->nombre; ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-11 sacarpadding">

                                            <?php 

                                                $MatrizBloque = [];
                                                if(ArrayHelper::keyExists($bloque->id, $MatrizDatosMapa, false)){
                                                    $MatrizBloque = $MatrizDatosMapa[$bloque->id];
                                                }


                                                foreach ($dias as $key => $dia) {

                                                    $MatrizDia = [];
                                                    if(ArrayHelper::keyExists($dia->id, $MatrizBloque, false)){
                                                        $MatrizDia = $MatrizBloque[$dia->id];
                                                    }

                                                    ?>

                                                        <div class="col-xs-2 fondotablacuadrosolo">


                                                            <?php 

                                                                if($confirmacion >= 1){
                                                                    if(!count($MatrizDia) > 0){
                                                                        ?>
                                                                            <div class="FondoBlancoTablasBotonVacio"> </div>
                                                                        <?php

                                                                    }else{

                                                                        ?>
                                                                            <div class="BotonSelecionadoFalsoAzul"> <?php echo $MatrizDatos[$MatrizDia]['hora_desde'].' a '.$MatrizDatos[$MatrizDia]['hora_hasta']; ?></div>
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    if(!count($MatrizDia) > 0){

                                                                        echo PopoverX::widget([
                                                                            'header' => '<i class="glyphicon glyphicon-edit"></i> Rango de Hora',
                                                                            'placement' => $dia->id > 4 ? PopoverX::ALIGN_LEFT : PopoverX::ALIGN_RIGHT,
                                                                            'size' => PopoverX::SIZE_LARGE,
                                                                            'options' => [
                                                                                'id' => 'PopoverX_'.$bloque->id.'_'.$dia->id,
                                                                            ],
                                                                            'content' => $this->render('_form_bloque',array('model'=>$model,'bloque'=>$bloque->id,'dia'=>$dia->id,'hora_desde'=>'08:00 AM','hora_hasta'=>'08:40 AM','boton_limpiar'=>true), false, true),

                                                                            'toggleButton' => ['label'=>'<i class="fa fa-clock-o"></i>', 'class'=>'btngrisChico'],
                                                                        ]);
                                                                    }else{
                                                                        echo PopoverX::widget([
                                                                            'header' => '<i class="glyphicon glyphicon-edit"></i> Rango de Hora',
                                                                            'placement' => $dia->id > 4 ? PopoverX::ALIGN_LEFT : PopoverX::ALIGN_RIGHT,
                                                                            'size' => PopoverX::SIZE_LARGE,
                                                                            'options' => [
                                                                                'id' => 'PopoverX_'.$bloque->id.'_'.$dia->id,
                                                                                'class'=>'popover-header popover-title',
                                                                            ],
                                                                            'content' => $this->render('_form_bloque',array('model'=>$model,'bloque'=>$bloque->id,'dia'=>$dia->id,'hora_desde'=>$MatrizDatos[$MatrizDia]['hora_desde'],'hora_hasta'=>$MatrizDatos[$MatrizDia]['hora_hasta'],'boton_limpiar'=>false), false, true),

                                                                            'toggleButton' => ['label'=>$MatrizDatos[$MatrizDia]['hora_desde'].' a '.$MatrizDatos[$MatrizDia]['hora_hasta'], 'class'=>'btn-celeste'],
                                                                        ]);
                                                                    }
                                                                }

                                                            ?>

                                                        </div>

                                                    <?php 

                                                }

                                            ?>

                                            </div>

                                        </div>

                                    <?php
                                }
                            
                            ?>
                        </div>
                        
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>


    <?php 

$this->registerJs("
        $(\".kv-editable-guardar\").click(function(e){
            e.preventDefault();
            var form = $(this).parent();
             // return false if form still have some validation errors
             if (form.find('.has-error').length) {
                  return false;
             }
             // submit form
             $.ajax({
                url: 'guardarbloque',
                type: 'post',
                data: form.serialize(),
                dataType:'json',
                success: function (response) {
                    // do something with response
                    if(response.status == 1){
                        form.parent().parent().popoverX('hide');
                        if( response.semana == 1 || response.semana_sabado == 1 ){
                            if( response.semana_sabado == 1 ){
                                form.parent().parent().parent().parent().parent().children('.col-xs-11').each(function( index ) {
                                    // console.log( index + \": \" + $( this ).text() );
                                    // console.log( index + \": \" + $( this ).find('.btn-sm').html() );
                                    $( this ).find('.btn-sm').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                                    $( this ).find('.kv-editable-reset').show();
                                });
                            }else{



                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);

                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_1']\").show();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_2']\").show();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_3']\").show();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_4']\").show();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_5']\").show();

                            }
                        }else{

                            // alert(form.parent().parent().parent().children('.btn-sm').html());
                            form.parent().parent().parent().children('.btn-sm').removeClass('btn btn-default-transparent btn-sm').addClass('btn btn-default btn-sm').html(response.dato_mostrar_boton);
                            form.parent().parent().parent().find('.kv-editable-reset').show();

                        }

                    }else{
                          if(response.validacion){
                                 // form.find('.error-summary').show();
                                 // form.find('.error-summary').find('ul').append(\"<li>\"+response.error+\"</li>\");
                            alert('El horario  debe ser mayor al del bloque anterior');
                            
                         }
                    }
                }
             });
             return false;
        
        });

        $(\".bootstrap-timepicker\").on('changeTime.timepicker', function(e) {

            var minValue = e.time.value;



            var hora_hasta = $(this).parent().parent().find(\"input[id*='hora_hasta_timepicker_']\");

             $.ajax({
                url: 'obtener-fecha-secundaria',
                type: 'post',
                data: {'hora':e.time.value},
                dataType:'json',
                success: function (response) {
                    // do something with response
                    if(response.status == 1){
                        hora_hasta.val(response.data);
                    }
                }
             });

        });

        $(\"input[id*='semana_sabado_CheckboxX_']\").change(function(e){
            if($(this).val() == 1){

                var attr = $(this).parent().parent().parent().find(\"input[id*='semana_CheckboxX_']\").attr(\"disabled\")
                var label_check = $(this).parent().parent().parent().find(\"input[id*='semana_CheckboxX_']\").parent().parent().find('label');
                label_check.toggleClass('disabled');
                if (typeof attr == 'undefined' || attr == false) {
                    $(this).parent().parent().parent().find(\"input[id*='semana_CheckboxX_']\").val(0).attr(\"disabled\", \"disabled\").checkboxX(\"refresh\");
                }
                else {
                    $(this).parent().parent().parent().find(\"input[id*='semana_CheckboxX_']\").val(0).removeAttr(\"disabled\").checkboxX(\"refresh\");
                }

            }else{
                $(this).parent().parent().parent().find(\"input[id*='semana_CheckboxX_']\").val(0).removeAttr(\"disabled\").checkboxX(\"refresh\");
            }
            
        });

        $(\"input[id*='semana_CheckboxX_']\").change(function(e){
            if($(this).val() == 1){

                var attr = $(this).parent().parent().parent().find(\"input[id*='semana_sabado_CheckboxX_']\").attr(\"disabled\")
                var label_check = $(this).parent().parent().parent().find(\"input[id*='semana_sabado_CheckboxX_']\").parent().parent().find('label');
                label_check.toggleClass('disabled');
                if (typeof attr == 'undefined' || attr == false) {
                    $(this).parent().parent().parent().find(\"input[id*='semana_sabado_CheckboxX_']\").val(0).attr(\"disabled\", \"disabled\").checkboxX(\"refresh\");
                }
                else {
                    $(this).parent().parent().parent().find(\"input[id*='semana_sabado_CheckboxX_']\").val(0).removeAttr(\"disabled\").checkboxX(\"refresh\");
                }

            }else{
                $(this).parent().parent().parent().find(\"input[id*='semana_sabado_CheckboxX_']\").val(0).removeAttr(\"disabled\").checkboxX(\"refresh\");
            }
        });

        $(\".kv-editable-reset\").click(function(e){
            
            if($(this).parent().find(\"input[id*='semana_sabado_CheckboxX_']\").val() == 1 && !$(this).parent().find(\"input[id*='semana_sabado_CheckboxX_']\").attr(\"disabled\")){
                if (!confirm(\"¿Estás seguro que quieres eliminar los datos de lunes a sabado?\")){
                  return false;
                }
            }
            if($(this).parent().find(\"input[id*='semana_CheckboxX_']\").val() == 1 && !$(this).parent().find(\"input[id*='semana_CheckboxX_']\").attr(\"disabled\")){
                if (!confirm(\"¿Estás seguro que quieres eliminar los datos de lunes a viernes?\")){
                  return false;
                }
            }
            if(!(($(this).parent().find(\"input[id*='semana_sabado_CheckboxX_']\").val() == 1 && !$(this).parent().find(\"input[id*='semana_sabado_CheckboxX_']\").attr(\"disabled\")) || ($(this).parent().find(\"input[id*='semana_CheckboxX_']\").val() == 1 && !$(this).parent().find(\"input[id*='semana_CheckboxX_']\").attr(\"disabled\")))){
                if (!confirm(\"Estás seguro que quieres eliminar este dato\")){
                  return false;
                }
            }


            e.preventDefault();
            var form = $(this).parent();
             // return false if form still have some validation errors
             if (form.find('.has-error').length) {
                  return false;
             }
             // submit form
             $.ajax({
                url: 'eliminarbloque',
                type: 'post',
                data: form.serialize(),
                dataType:'json',
                success: function (response) {
                    // do something with response
                    if(response.status == 1){
                        form.parent().parent().popoverX('hide');
                        if( response.semana == 1 || response.semana_sabado == 1 ){
                            if( response.semana_sabado == 1 ){
                                form.parent().parent().parent().parent().parent().children('.col-xs-11').each(function( index ) {
                                    // console.log( index + \": \" + $( this ).text() );
                                    // console.log( index + \": \" + $( this ).find('.btn-sm').html() );
                                    $( this ).find('.btn-sm').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                                    $( this ).find(\"button[id*='boton_cerrar_\"+response.bloque+\"']\").hide();
                                });
                            }else{

                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                                form.parent().parent().parent().parent().parent().find('.col-xs-11').find(':first-child').next().next().next().next().find('button:not(.close, .kv-editable-submit, .kv-editable-reset)').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');

                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_1']\").hide();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_2']\").hide();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_3']\").hide();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_4']\").hide();
                                $(\"button[id*='boton_cerrar_\"+response.bloque+\"_5']\").hide();

                            }
                        }else{

                            // alert(form.parent().parent().parent().children('.btn-sm').html());
                            form.parent().parent().parent().children('.btn-sm').removeClass('btn btn-default btn-sm').addClass('btn btn-default-transparent btn-sm').html('<i class=\"fa fa-clock-o\"></i>');
                            $(\"button[id*='boton_cerrar_\"+response.bloque+\"_\"+response.dia_id+\"']\").hide();
                        }

                    }
                }
             });
             return false;

        });

"); 

?>




</main>


