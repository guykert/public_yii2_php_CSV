<?php 

use common\models\TemplateHijo;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use common\assets\ViewAsset;
use common\models\SubRamo;
use yii\helpers\ArrayHelper;

ViewAsset::register($this);



?>


<div class="card-footer  contenedor_general_horario_curso">

<?= Html::a('Crear Horario Curso', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-success-crear']) ?>
<div class="row">
    <div class="col-xs-1">
        <div class="col-xs-12">

        </div>
    </div>
    <div class="col-xs-11">

        <?php 



        ?>


    </div>
</div>


</div>

<?php 

$this->registerJs("




    $('.btn-success-crear').click(function(e){
        e.preventDefault();



        cargarEstructuraTab2('crear-horario-curso','#tabArticuloHorario');

    }); 

    function cargarEstructuraTab2(tabNombre,activeTab) {




        $.ajax({
            url: tabNombre,
            data:{id:" . $model->id . "},
            beforeSend:function(){
                $('#resultado').html('<div class=\"sk-circle11 sk-child\"></div>');
            },
            success: function(data) {

                var	activeTab =$('.contenedor_general_horario_curso').parent();
                
                activeTab.fadeOut().empty();
                activeTab.append(data).fadeIn();

                return true;
            }
        });


    }

"); 

?>