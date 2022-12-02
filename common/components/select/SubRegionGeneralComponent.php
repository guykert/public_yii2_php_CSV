<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\TemplateRegion;

    class SubRegionGeneralComponent extends Component {


        public function RecibirInformacion()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_template']) && $_POST['depdrop_all_params']['id_template'] > 0) && (isset($_POST['depdrop_all_params']['id_template_region_general']) && $_POST['depdrop_all_params']['id_template_region_general'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_template_region_general'];

                $parents = $_POST['depdrop_parents'];

                $template_id = $parents[0];

                $id_template_region_general = $_POST['depdrop_all_params']['id_template_region_general'];


                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = TemplateRegion::getRegionComboDep($id_template_region_general);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['template_region_id_selected']) && $_POST['depdrop_all_params']['template_region_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['template_region_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{



                $parents = $_POST['depdrop_parents'];
                $template_id = $parents[0];
                $id_template_region_general = $parents[1];
                if($id_template_region_general != null)
                {


                    $out = TemplateRegion::getRegionComboDep($id_template_region_general);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

