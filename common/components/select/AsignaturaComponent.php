<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\MallaHorariaCurso;

    class AsignaturaComponent extends Component {


        public function AsignaturasPorCurso()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_curso']) && $_POST['depdrop_all_params']['id_curso'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_curso'];

                $parents = $_POST['depdrop_parents'];

                $curso_id = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = MallaHorariaCurso::getAsignaturasCursoComboDependiente($curso_id);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['asignatura_id_selected']) && $_POST['depdrop_all_params']['asignatura_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['asignatura_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{



                $parents = $_POST['depdrop_parents'];
                $curso_id = $parents[0];
                if($curso_id != null)
                {


                    $out = MallaHorariaCurso::getAsignaturasCursoComboDependiente($curso_id);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

