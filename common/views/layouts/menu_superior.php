<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Empresa;
use common\components\getimgComponent;



?>

<header class="app-header navbar">
      <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
      <span class="navbar-toggler-icon"></span>
      </button>
      <?=Html::a('', ['/site/go-home'], ['class' => 'navbar-brand']);?>

      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
      <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none mr-auto">

      <li class="nav-item px-3">
      <a class="nav-link" href="#">Dashboard</a>
      </li>
      <li class="nav-item px-3">
      <a class="nav-link" href="#">Users</a>
      </li>
      <li class="nav-item px-3">
      <a class="nav-link" href="#">Settings</a>
      </li>
      </ul>
      <ul class="nav navbar-nav ml-auto">
      <li class="nav-item ">
            <span class="nombresuperiordetodo"> <?php echo Yii::$app->user->identity->nombre . " " . Yii::$app->user->identity->apellido_paterno; ?> / <?php echo Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada); ?> </span> 
      </li>
      <li class="nav-item dropdown d-md-down-none">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
      <div class="dropdown-header text-center">
      <strong>You have 5 notifications</strong>
      </div>
      <a href="#" class="dropdown-item">
      <i class="icon-user-follow text-success"></i> New user registered
      </a>
      <a href="#" class="dropdown-item">
      <i class="icon-user-unfollow text-danger"></i> User deleted
      </a>
      <a href="#" class="dropdown-item">
      <i class="icon-chart text-info"></i> Sales report is ready
      </a>
      <a href="#" class="dropdown-item">
      <i class="icon-basket-loaded text-primary"></i> New client
      </a>
      <a href="#" class="dropdown-item">
      <i class="icon-speedometer text-warning"></i> Server overloaded
      </a>
      <div class="dropdown-header text-center">
      <strong>Server</strong>
      </div>
      <a href="#" class="dropdown-item">
      <div class="text-uppercase mb-1">
      <small><b>CPU Usage</b></small>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      <small class="text-muted">348 Processes. 1/4 Cores.</small>
      </a>
      <a href="#" class="dropdown-item">
      <div class="text-uppercase mb-1">
      <small><b>Memory Usage</b></small>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      <small class="text-muted">11444GB/16384MB</small>
      </a>
      <a href="#" class="dropdown-item">
      <div class="text-uppercase mb-1">
      <small><b>SSD 1 Usage</b></small>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      <small class="text-muted">243GB/256GB</small>
      </a>
      </div>
      </li>
      <li class="nav-item dropdown d-md-down-none">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="icon-list"></i><span class="badge badge-pill badge-warning">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
      <div class="dropdown-header text-center">
      <strong>You have 5 pending tasks</strong>
      </div>
      <a href="#" class="dropdown-item">
      <div class="small mb-1">Upgrade NPM &amp; Bower
      <span class="float-right">
      <strong>0%</strong>
      </span>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      </a>
      <a href="#" class="dropdown-item">
      <div class="small mb-1">ReactJS Version
      <span class="float-right">
      <strong>25%</strong>
      </span>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      </a>
      <a href="#" class="dropdown-item">
      <div class="small mb-1">VueJS Version
      <span class="float-right">
      <strong>50%</strong>
      </span>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      </a>
      <a href="#" class="dropdown-item">
      <div class="small mb-1">Add new layouts
      <span class="float-right">
      <strong>75%</strong>
      </span>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      </a>
      <a href="#" class="dropdown-item">
      <div class="small mb-1">Angular 2 Cli Version
      <span class="float-right">
      <strong>100%</strong>
      </span>
      </div>
      <span class="progress progress-xs">
      <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
      </span>
      </a>
      <a href="#" class="dropdown-item text-center">
      <strong>View all tasks</strong>
      </a>
      </div>
      </li>
      <li class="nav-item dropdown d-md-down-none">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="icon-envelope-letter"></i><span class="badge badge-pill badge-info">7</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
      <div class="dropdown-header text-center">
      <strong>You have 4 messages</strong>
      </div>
      <a href="#" class="dropdown-item">
      <div class="message">
      <div class="py-3 mr-3 float-left">
      <div class="avatar">
      <!-- <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
      <span class="avatar-status badge-success"></span>
      </div>
      </div>
      <div>
      <small class="text-muted">John Doe</small>
      <small class="text-muted float-right mt-1">Just now</small>
      </div>
      <div class="text-truncate font-weight-bold">
      <span class="fa fa-exclamation text-danger"></span> Important message</div>
      <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
      </div>
      </a>
      <a href="#" class="dropdown-item">
      <div class="message">
      <div class="py-3 mr-3 float-left">
      <div class="avatar">
      <!-- <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
      <span class="avatar-status badge-warning"></span>
      </div>
      </div>
      <div>
      <small class="text-muted">John Doe</small>
      <small class="text-muted float-right mt-1">5 minutes ago</small>
      </div>
      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
      <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
      </div>
      </a>
      <a href="#" class="dropdown-item">
      <div class="message">
      <div class="py-3 mr-3 float-left">
      <div class="avatar">
      <!-- <img src="img/avatars/5.jpg" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
      <span class="avatar-status badge-danger"></span>
      </div>
      </div>
      <div>
      <small class="text-muted">John Doe</small>
      <small class="text-muted float-right mt-1">1:52 PM</small>
      </div>
      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
      <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
      </div>
      </a>
      <a href="#" class="dropdown-item">
      <div class="message">
      <div class="py-3 mr-3 float-left">
      <div class="avatar">
      <!-- <img src="img/avatars/4.jpg" class="img-avatar" alt="admin@bootstrapmaster.com"> -->
      <span class="avatar-status badge-info"></span>
      </div>
      </div>
      <div>
      <small class="text-muted">John Doe</small>
      <small class="text-muted float-right mt-1">4:03 PM</small>
      </div>
      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
      <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
      </div>
      </a>
      <a href="#" class="dropdown-item text-center">
      <strong>View all messages</strong>
      </a>
      </div>
      </li>
      <li class="nav-item dropdown">


      <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      
            <?php


                  if(Yii::$app->user->identity->image_name != ""){

                        ?>
                              <img src="<?php echo  Url::to(['/imagenes', 'ruta' => Yii::$app->user->identity->image_name, 'tipo_imagen' => 'personal']) ; ?>" class="img-avatar" alt="admin@bootstrapmaster.com">
                        <?php

                  }else{
                  
                        ?>
                              <img src="<?= Yii ::getAlias('@web').'/img/no_imagen.png';?>" class="img-avatar" alt="admin@bootstrapmaster.com">
                        <?php 

                  }


            ?>

      </a>


      


      
      


      <div class="dropdown-menu dropdown-menu-right">
      <div class="dropdown-header text-center">

      <strong>Settings</strong>
      </div>
            <?= Html::a('<i class="fa fa-user"></i> Perfil', ['/identificar/perfil'], ['class' => 'dropdown-item']) ?>
            <?= Html::a('<i class="fa fa-wrench"></i> Settings', ['/identificar/settings'], ['class' => 'dropdown-item']) ?>

      <div class="divider"></div>
            <?= Html::a('<i class="fa fa-lock"></i> Salir', ['/site/logout'], ['class' => 'dropdown-item']) ?>
      </div>
      </li>
      <button class="navbar-toggler aside-menu-toggler" type="button">
      <span class="navbar-toggler-icon"></span>
      </button>

      </ul>
</header>