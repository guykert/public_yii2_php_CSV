<div class="sidebar">




      <nav class="sidebar-nav">



            <ul class="nav">


                  <?php
                        if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador')){
                        
                        echo $this->render('menu_izquierdo_admin.php');

                        }
                  ?>

                  <?php
                        if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador') || Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'sub_administrador')){
                        
                        echo $this->render('menu_izquierdo_sub_admin.php');

                        }
                  ?>


                  <?php
                        if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador')){
                        
                        echo $this->render('menu_crear_colegio.php');

                        }
                  ?>

            

            <!-- 

                  <li class="divider m-2"></li>
                  <li class="nav-title">
                        Labels
                  </li>
                  <li class="nav-item hidden-cn">
                        <a class="nav-label" href="#"><i class="fa fa-circle text-danger"></i> Label danger</a>
                  </li>
                  <li class="nav-item hidden-cn">
                        <a class="nav-label" href="#"><i class="fa fa-circle text-info"></i> Label info</a>
                  </li>
                  <li class="nav-item hidden-cn">
                        <a class="nav-label" href="#"><i class="fa fa-circle text-warning"></i> Label warning</a>
                  </li>
                  <li class="divider"></li>
                  <li class="nav-title">
                        System Utilization
                  </li>
                  <li class="nav-item px-3 hidden-cn">
                        <div class="text-uppercase mb-1">
                        <small><b>CPU Usage</b></small>
                        </div>
                        <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">348 Processes. 1/4 Cores.</small>
                  </li>
                  <li class="nav-item px-3 hidden-cn">
                        <div class="text-uppercase mb-1">
                        <small><b>Memory Usage</b></small>
                        </div>
                        <div class="progress progress-xs">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">11444GB/16384MB</small>
                  </li>
                  <li class="nav-item px-3 hidden-cn">
                        <div class="text-uppercase mb-1">
                              <small><b>SSD 1 Usage</b></small>
                        </div>
                        <div class="progress progress-xs">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">243GB/256GB</small>
                  </li> 
            
            -->

            </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>