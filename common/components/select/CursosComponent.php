<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\Curso;

    class CursosComponent extends Component {


        public function RecibirInformacion()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_empresa']) && $_POST['depdrop_all_params']['id_empresa'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_empresa'];

                $parents = $_POST['depdrop_parents'];

                $id_empresa = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = Curso::getActivoCursosComboDependiente($id_empresa);

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



                $parents = $_POST['depdrop_parents'];
                $id_empresa = $parents[0];
                if($id_empresa != null)
                {


                    $out = Curso::getActivoCursosComboDependiente($id_empresa);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }

        public function RecibirInformacionInforme()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_nivel']) && $_POST['depdrop_all_params']['id_nivel'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_nivel'];

                $parents = $_POST['depdrop_parents'];

                $id_nivel = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = Curso::getActivoCursosComboDependienteNivel($id_nivel);

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



                $parents = $_POST['depdrop_parents'];
                $id_nivel = $parents[0];
                if($id_nivel != null)
                {


                    $out = Curso::getActivoCursosComboDependienteNivel($id_nivel);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

