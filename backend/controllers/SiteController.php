<?php
namespace backend\controllers;

use Yii;
use common\controllers\SiteController as SiteControllerCommon;

/**
 * Site controller
 */
class SiteController extends SiteControllerCommon
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        if(!(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador'))){
        
            return $this->redirect(['site/logout', 'error' => 1]);

        }



        $this->layout ='@common/views/layouts/general';
        return $this->render('@common/views/site/index');
    }

}
