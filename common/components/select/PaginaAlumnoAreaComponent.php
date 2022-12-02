<?php 

    namespace common\components\select;


    use Yii;
    use yii\base\Component;
    use yii\helpers\Json;
    use common\models\PaginaAlumnoArea;

    class PaginaAlumnoAreaComponent extends Component {


        public function RecibirInformacion()
        {




            // inicializamos las variables
            $out = [];
            $selected  = null;

            // Preguntamos si vienen datos del periodo para diferenciar la carga por defecto de la carga con data seleccionada

            if ((isset($_POST['depdrop_all_params']['id_pagina_alumno']) && $_POST['depdrop_all_params']['id_pagina_alumno'] > 0)) {

            


                $id = $_POST['depdrop_all_params']['id_pagina_alumno'];

                $parents = $_POST['depdrop_parents'];

                $id_pagina_alumno = $parents[0];



                if($id != null)
                {


                        // realizo el select en la base de datos

                        $list = PaginaAlumnoArea::getPaginaAlumnoArea($id_pagina_alumno);

                        foreach ($list as $i => $account) {
                                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                        }

                        // veo si viene un valor como select
                        if (isset($_POST['depdrop_all_params']['pagina_alumno_area_id_selected']) && $_POST['depdrop_all_params']['pagina_alumno_area_id_selected'] > 0) {
                            $selected = $_POST['depdrop_all_params']['pagina_alumno_area_id_selected'];
                        }


                    return Json::encode(['output' => $out , 'selected'=>$selected]);
                }
            }else{



                $parents = $_POST['depdrop_parents'];
                $id_pagina_alumno = $parents[0];
                if($id_pagina_alumno != null)
                {


                    $out = PaginaAlumnoArea::getPaginaAlumnoArea($id_pagina_alumno);


                    // realizo el select en la base de datos




                }
                // retorno la información para poblar el combo

                return Json::encode(['output' => $out , 'selected'=>null]);

            }


        }


    }

?>

