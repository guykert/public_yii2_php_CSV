<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\Prueba;

    class NivelComponent extends Component {


        public function RecibirInformacion()
        {

            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_empresa']) && $_POST['depdrop_all_params']['id_empresa'] > 0)) {

                $id_empresa = $_POST['depdrop_all_params']['id_empresa'];

                if(($id_empresa != null))
                {


                        // realizo el select en la base de datos

                        $list = Nivel::getNiveles($id_empresa);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['curso_id_selected']) && $_POST['depdrop_all_params']['curso_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['curso_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{

                $id_empresa = "";

                if(($id_empresa != null))
                {


                    $out = Nivel::getNiveles($id_empresa);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }

        }

        public function PruebasColegio()
        {

            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_empresa_origen']) && $_POST['depdrop_all_params']['id_empresa_origen'] > 0)) {

                $id_empresa_origen = $_POST['depdrop_all_params']['id_empresa_origen'];

                if(($id_empresa_origen != null))
                {


                        // realizo el select en la base de datos

                        $list = Prueba::getActivoPruebasColegio();

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['curso_id_selected']) && $_POST['depdrop_all_params']['curso_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['curso_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{

                //$parents = $_POST['depdrop_parents'];
                $id_nivel = "";

                $id_ramo = "";

                $id_categoria_prueba = "";

                if(($id_nivel != null) || ($id_ramo != null) || ($id_categoria_prueba != null))
                {


                    $out = Prueba::getActivoPruebasColegio();


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }

        }


    }

?>

