<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\TemplateRegionGeneral;

    class RegionGeneralComponent extends Component {


        public function RecibirInformacion()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['template_id']) && $_POST['depdrop_all_params']['template_id'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['template_id'];

                $parents = $_POST['depdrop_parents'];

                $template_id = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = TemplateRegionGeneral::getRegionGeneralComboDep($template_id);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['template_region_general_id_selected']) && $_POST['depdrop_all_params']['template_region_general_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['template_region_general_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{



                $parents = $_POST['depdrop_parents'];
                $template_id = $parents[0];
                if($template_id != null)
                {


                    $out = TemplateRegionGeneral::getRegionGeneralComboDep($template_id);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

