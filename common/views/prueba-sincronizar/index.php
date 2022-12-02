<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\export\ExportMenuAsset;
use kartik\helpers\Enum;
use yii\bootstrap\Progress;
use common\assets\MantenedoresAsset;
use yii\widgets\Breadcrumbs;

MantenedoresAsset::register($this);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require __DIR__ . '/../../../vendor/autoload.php';

// Create new Spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

use kartik\icons\Icon;
Icon::map($this); 


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Dia */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dias';

$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];

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

            <div class="fondo">
                <div class="titulo"><div class="container"><i class="fa fa-angle-right colorceleste"></i> Sincronizar Pruebas Externas</div></div>
                <div class="container fondo-form">
                    <div class="ramo-index">
                        <div class="col-md-12 sin-padding">
                            <div class="col-md-10 sin-padding">
                                <span class="ti-barra">Progreso de la sincronización</span>

                                <?php 


                                // striped animated
                                echo Progress::widget([
                                    'percent' => 0,
                                    'barOptions' => ['class' => 'progress-bar-success'],
                                    'options' => ['class' => 'active progress-striped']
                                ]);


                                ?>


                            </div>
                            <div class="col-md-2">
                                <?= Html::a('Sincronizar <i class="BotonTextoBlancos fa fa-pencil-square-o"></i>', [''], ['id'=>'boton_sincronizar','class'=>'btn btn-azul btn-animated btn-md',' style'=>'color:#fff;']) ?>

                            </div>
                        </div>
                        <hr>
                        <br>
                        <br>
                        

                        <div class=" isotope-item" style="">
                            <div class="titulo2"><div class="container">Full Ejercicios</div></div>
                            <br>
                            <div class="tab-content">
                                <div id="roles" class="tab-pane active">
                                    <div class="">
                                        <ul class="nav nav-tabs nav-stacked">

                                            <?php 

                                                // Recorro los subRoles
                                                foreach($Pruebas as $prueba):
                                                    ?>
                                                        <li>
                                                            <div class="col-md-4"><h4 class="subtema"><i class="fa fa-angle-double-right colorcyan"></i> <?php echo $prueba->nombre ?></div>

                                                            <div class="col-md-2" id="prueba_id_cont<?=$prueba->id;?>">

                                                                <?= Html::a('Pendiente <i class="BotonTextoBlancos fa fa-pencil-square-o"></i>', [''], ['id'=>'prueba_id_'.$prueba->id,'class'=>'btn btn-danger btn-animated btn-md','prueba_id'=>$prueba->id,'style'=>'color:#fff;']) ?>

                                                            </div>
                                                        </li>
                                                    <?php

                                                endforeach; 

                                            ?>

                                        </ul>


                                    </div>
                                </div>

                            </div><!--isotope-->
                        </div>


                </div><!--container-->
            </div>


            
          
        </div>
        <br><br><br>
    </div><!--container-->
</main>



<?php 

$this->registerJs("

    var cantidad_pruebas = " . count($Pruebas) . ";

    $(\"#boton_sincronizar\").click(function(e){

            e.preventDefault();
            buscarSwishOff();

    });

    $(\".btn-success\").click(function(e){

            e.preventDefault();

    });


    $(\".btn-danger\").click(function(e){

        e.preventDefault();
        var _url;
        _url='prueba-sincronizar/sincronizar-prueba';
        $.ajax({
            url: _url,
            data: {'id_prueba':$(this).attr( \"prueba_id\" ),'id_moodle':'" . $id . "'},
            'dataType':'json',
            'type':'POST',
            'success':function(data)
            {

                if(data.status == 1){

                    enviarSolicitudSolucionarioUnico(data.id_prueba);
                    
                }



            } ,
        'cache':false});

    });

    function enviarSolicitudSolucionarioUnico(prueba_id) {


            var _url;
            _url='prueba-sincronizar/sincronizar-solucionario';
            $.ajax({
                url: _url,
                data: {'id_prueba':prueba_id,'id_moodle':'" . $id . "'},
                'dataType':'json',
                'type':'POST',
                'success':function(data)
                {

                    if(data.status == 1){
                        enviarSolicitudSolucionarioTeoricoUnico(prueba_id);

                    }



                } ,
            'cache':false});


    }

    function enviarSolicitudSolucionarioTeoricoUnico(prueba_id) {


            var _url;
            _url='prueba-sincronizar/sincronizar-solucionario-teorico';
            $.ajax({
                url: _url,
                data: {'id_prueba':prueba_id,'id_moodle':'" . $id . "'},
                'dataType':'json',
                'type':'POST',
                'success':function(data)
                {

                    if(data.status == 1){
                        $(\"#prueba_id_cont\" + data.id_prueba).empty();
                        $(\"#prueba_id_cont\" + data.id_prueba).append('<a id=\"prueba_id_1\" class=\"btn btn-success btn-animated btn-md\" href=\"\" prueba_id=\"1\" style=\"color:#fff;\">Listo <i class=\"BotonTextoBlancos fa fa-pencil-square-o\"></i></a>');

                        if($('.btn-danger').length == 0 || cantidad_pruebas == 0){
                            $('.progress-bar-success').attr('style','width: 100%');
                        }else{
                            var porcentaje = ((($('.btn-danger').length / cantidad_pruebas) - 1) * (-100)).toFixed(2);

                            $('.progress-bar-success').attr('style','width: ' + porcentaje + '%');
                        }

                    }



                } ,
            'cache':false});


    }

    function buscarSwishOff() {

        $('.btn-danger').first().each(function (index) 
        { 
            var _url;
            enviarSolicitudPrueba($(this).attr( \"prueba_id\" ));
        }) 

    }

    function enviarSolicitudPrueba(prueba_id) {


            var _url;
            _url='prueba-sincronizar/sincronizar-prueba';
            $.ajax({
                url: _url,
                data: {'id_prueba':prueba_id,'id_moodle':'" . $id . "'},
                'dataType':'json',
                'type':'POST',
                'success':function(data)
                {

                    if(data.status == 1){
                        enviarSolicitudSolucionario(prueba_id);

                    }



                } ,
            'cache':false});


    }

    function enviarSolicitudSolucionario(prueba_id) {


            var _url;
            _url='prueba-sincronizar/sincronizar-solucionario';
            $.ajax({
                url: _url,
                data: {'id_prueba':prueba_id,'id_moodle':'" . $id . "'},
                'dataType':'json',
                'type':'POST',
                'success':function(data)
                {

                    if(data.status == 1){
                        enviarSolicitudSolucionarioTeorico(prueba_id);

                    }



                } ,
            'cache':false});


    }

    function enviarSolicitudSolucionarioTeorico(prueba_id) {


            var _url;
            _url='prueba-sincronizar/sincronizar-solucionario-teorico';
            $.ajax({
                url: _url,
                data: {'id_prueba':prueba_id,'id_moodle':'" . $id . "'},
                'dataType':'json',
                'type':'POST',
                'success':function(data)
                {

                    if(data.status == 1){
                        $(\"#prueba_id_cont\" + data.id_prueba).empty();
                        $(\"#prueba_id_cont\" + data.id_prueba).append('<a id=\"prueba_id_1\" class=\"btn btn-success btn-animated btn-md\" href=\"\" prueba_id=\"1\" style=\"color:#fff;\">Listo <i class=\"BotonTextoBlancos fa fa-pencil-square-o\"></i></a>');

                        if($('.btn-danger').length == 0 || cantidad_pruebas == 0){
                            $('.progress-bar-success').attr('style','width: 100%');
                        }else{
                            var porcentaje = ((($('.btn-danger').length / cantidad_pruebas) - 1) * (-100)).toFixed(2);

                            $('.progress-bar-success').attr('style','width: ' + porcentaje + '%');
                        }

                        buscarSwishOff();

                    }



                } ,
            'cache':false});


    }

"); 

?>