<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\Prueba;

    class PruebasComponent extends Component {


        public function RecibirInformacionInforme()
        {

            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_nivel']) && $_POST['depdrop_all_params']['id_nivel'] > 0) || (isset($_POST['depdrop_all_params']['id_ramo']) && $_POST['depdrop_all_params']['id_ramo'] > 0) || (isset($_POST['depdrop_all_params']['id_categoria_prueba']) && $_POST['depdrop_all_params']['id_categoria_prueba'] > 0)) {

                $id_nivel = $_POST['depdrop_all_params']['id_nivel'];

                $id_ramo = $_POST['depdrop_all_params']['id_ramo'];

                $id_categoria_prueba = $_POST['depdrop_all_params']['id_categoria_prueba'];



                if(($id_nivel != null) || ($id_ramo != null) || ($id_categoria_prueba != null))
                {


                        // realizo el select en la base de datos

                        $list = Prueba::getActivoPruebasComboDependiente($id_nivel,$id_ramo,$id_categoria_prueba);

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


                    $out = Prueba::getActivoPruebasComboDependiente($id_nivel,$id_ramo,$id_categoria_prueba);


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

                        $list = Prueba::getActivoPruebasColegio($id_empresa_origen);

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


                    $out = Prueba::getActivoPruebasColegio($id_empresa_origen);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }

        }


    }

?>

