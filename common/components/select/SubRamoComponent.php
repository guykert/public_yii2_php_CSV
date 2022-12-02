<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\SubRamo;

    class SubRamoComponent extends Component {


        public function RecibirInformacion()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_ramo']) && $_POST['depdrop_all_params']['id_ramo'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_ramo'];

                $parents = $_POST['depdrop_parents'];

                $ramo_id = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = SubRamo::getSubRamoColegio($ramo_id);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['sub_ramo_id_selected']) && $_POST['depdrop_all_params']['sub_ramo_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['sub_ramo_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{



                $parents = $_POST['depdrop_parents'];
                $ramo_id = $parents[0];
                if($ramo_id != null)
                {


                    $out = SubRamo::getSubRamoColegio($ramo_id);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

