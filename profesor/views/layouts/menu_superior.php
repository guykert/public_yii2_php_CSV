<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\RamoHijo;
use common\models\Empresa;
use common\components\getimgComponent;



?>

<header class="app-header navbar">
      <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">

      </button>
      <?=Html::a('', ['/site/go-home'], ['class' => 'navbar-brand']);?>

      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">

      </button>
      <ul class="nav navbar-nav d-md-down-none mr-auto">

      <?php



            // if(count(Yii::$app->session->get('RamoHijo')) > 0){

            //       // foreach (Yii::$app->session->get('RamoHijo') as $key => $RamoHijo) {
            //       //       echo "<li class=\"nav-item px-3\">";
      
            //       //       echo Html::a($RamoHijo['nombre'], ['/home','curso_id'=>$RamoHijo['id']], ['class'=>' nav-link']) ;
                        
            //       //       echo "</li>";
            //       // }

            // }else{

            //       // Yii::$app->session->set('RamoHijo',RamoHijo::getRamosColegioObj(Yii::$app->user->identity->colegio_predeterminada));

            //       // foreach (Yii::$app->session->get('RamoHijo') as $key => $RamoHijo) {
            //       //       echo "<li class=\"nav-item px-3\">";
      
            //       //       echo Html::a($RamoHijo['nombre'], ['/home','curso_id'=>$RamoHijo['id']], ['class'=>' nav-link']) ;
                        
            //       //       echo "</li>";
            //       // }

            // }

            


      ?>

      </ul>
      <ul class="nav navbar-nav ml-auto">

      <li class="nav-item ">
            <span class="nombresuperiordetodo"> <?php echo Yii::$app->user->identity->nombre . " " . Yii::$app->user->identity->apellido_paterno; ?> / <?php echo Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada); ?> </span> 
      </li>

            <li class="nav-item dropdown">


                  <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" style="margin-right: 100px;" aria-expanded="false">
                  
                        <?php


                              if(Yii::$app->user->identity->image_name != ""){

                                    ?>
                                          <img src="/profesor/img/no_imagen.png" class="img-avatar" alt="admin@bootstrapmaster.com">
                                          <!-- <img src="<?php //echo  Url::to(['/imagenes', 'ruta' => Yii::$app->user->identity->image_name, 'tipo_imagen' => 'personal']) ; ?>" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
                                    <?php

                              }else{
                              
                                    ?>
                                    
                                          <img src="/profesor/img/no_imagen.png" class="img-avatar" alt="admin@bootstrapmaster.com">

                                    <?php 

                              }


                        ?>

                  </a>


                  <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-header text-center">

                  <strong>Cuenta</strong>
                  </div>
                        <?= Html::a('<i class="fa fa-user"></i> Perfil', ['/identificar/perfil'], ['class' => 'dropdown-item']) ?>
                        

                  <div class="divider"></div>
                        <?= Html::a('<i class="fa fa-lock"></i> Salir', ['/site/logout'], ['class' => 'dropdown-item']) ?>
                  </div>
            </li>


      </ul>
</header>