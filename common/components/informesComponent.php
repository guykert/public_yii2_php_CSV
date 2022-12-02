<?php 

    namespace common\components;


    use Yii;
    use yii\base\Component;


    class informesComponent extends Component {


        public static function porcentajes($valor_parcial="0",$valor_total="0")
        {

            if($valor_total == "0" || $valor_parcial == "0"){

                $test = "0";
                
                return $test;

            }else{

                $test = "0";

                //return round((($valor_parcial * 100) / $valor_total),2);
                return $test;

            }


        }


    }

?>

