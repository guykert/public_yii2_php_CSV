<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\MallaHorariaColegio;

    class MallaHorariaComponent extends Component {




        public function MallaColegio()
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

                        $list = MallaHorariaColegio::getActivoMayasColegio($id_empresa_origen);

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


                    $out = MallaHorariaColegio::getActivoMayasColegio($id_empresa_origen);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }

        }


    }

?>

