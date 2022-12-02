<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="cabecerafondo">
    <div class="main">

        <?=  Breadcrumbs::widget([
            'class'=>'breadcrumb',
            'itemTemplate' => "<li  class=\"breadcrumb-item\">{link}</li>\n", 
            'homeLink' =>[
                'label' => 'Inicio', 'url' => ['/seleccionar-curso'],
                'template' => "<li  class=\"breadcrumb-item\">{link}</li>\n", // template for this link only
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>


    </div>
</div>


<div class="app-body" style="margin-top:0px; display: block;">

    <main>

        <div class="cajafondoprincipalnuevo">

            <div class="contenedorcajaparatodo">

                <br>

                <div class="row" style="justify-content: center;">
                    <?php

                        foreach ($RamoHijo as $key => $value) {

                            ?>

                                <div class="col-md-4">
                                <div class="card text-white <?php echo $value["codigo"];?>color">
                                    <div class="card-body">
                                    <div class="h1 text-muted text-right mb-4">
                                        <i class="icon-book-open"></i>
                                    </div>
                                    <div class="h2 mb-0"><?php echo $value["nombre"];?></div>
                                    <small class="text-muted text-uppercase font-weight-bold">Asignatura</small>
                                    <div><hr></div>
                                        <div class="row">
                                        <div class="col-md-12">

                                            <?php

                                                echo Html::a('<i class="fa fa-angle-right "></i>  Entrar', ['/home','curso_id'=>$value['id']], ['class'=>'btngris btn-next btn-block']) ;

                                            ?>

                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <?php   

                        }


                    ?>

                </div>

            </div>
            
        </div>

    </main>

</div>

