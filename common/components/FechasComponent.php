<?php 

namespace common\components;


use Yii;
use yii\base\Component;

class FechasComponent extends Component {

    public $fecha_inicio='';
    public $fecha_final='';
    public $fecha_hoy='';
    public $fecha_inicio_mostrar='';
    public $fecha_final_mostrar='';
    public $fecha_inicio_d_m='';
    public $fecha_final_d_m='';
    public $fecha_hoy_mostrar='';
    public $fecha_dia='';
    public $fecha=0;
    public $mes=0;
    public $fecha_dia_anterior='';
    public $array_fechas = [];
    public $array_fechas_semana = [];

    public  function fechaInicioFinSemana($fecha_dia="",$fecha_inicio="",$fecha_final="",$fecha_solo_dia="")
    {


        if($fecha_dia ==""){

            $fecha_actual = strtotime(date('Y-m-d'));

        }



        if($fecha_dia !=""){





            $this->fecha = $fecha_dia;
            $dia = date("d",strtotime($fecha_dia));
            $mes = date("m",strtotime($fecha_dia));


            $año = date("Y",strtotime($fecha_dia));
            $diaSemana=date("N",strtotime($fecha_dia));
            $this->fecha_dia =$diaSemana; 
            $this->mes=date("m",strtotime($fecha_inicio));
            if ($fecha_inicio == "") {
                $this->fecha_inicio = date("Y-m-d",mktime(0,0,0,$mes,$dia - ($diaSemana - 1 ),$año));
            }else{
                $this->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
            }



            if ($fecha_final == "") {
                $this->fecha_final = date("Y-m-d",mktime(0,0,0,$mes,$dia - $diaSemana + 7,$año));
            }else{
                $this->fecha_final = date('Y-m-d', strtotime($fecha_final));
            }




            setlocale(LC_TIME,"es_ES.UTF-8");
            $this->fecha_inicio_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_inicio. ' +1 day'));
            $this->fecha_final_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_final. ' +1 day'));
            $this->fecha_inicio_d_m = strftime("%A, %d de %B", strtotime($this->fecha_inicio));
            $this->fecha_final_d_m = strftime("%A, %d de %B", strtotime($this->fecha_final));
            $this->fecha_hoy = date("Y-m-d",strtotime($fecha_dia));

            $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_hoy));
            $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_hoy));


            $this->fecha_dia_anterior = date('Y-m-d',strtotime($this->fecha_hoy. ' -1 day'));
            

        }else{



            $dia = date("d");
            // $dia_seleccionado = date("d",strtotime($fecha_inicio));
            $mes = date("m");
            $año = date("Y");
            // $diaSemana=date("w",strtotime($fecha_inicio));

            $diaSemana=date("N");
            $this->fecha_dia =$diaSemana; 
            $this->mes=date("m");



            if ($fecha_inicio == "") {


                $this->fecha_inicio = date("Y-m-d",mktime(0,0,0,$mes,$dia - ($diaSemana - 1 ),$año));



            }else{
                $this->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
            }



            if ($fecha_final == "") {
                $this->fecha_final = date("Y-m-d",mktime(0,0,0,$mes,$dia - $diaSemana + 7,$año));
            }else{
                $this->fecha_final = date('Y-m-d', strtotime($fecha_final));
            }

            


            


            setlocale(LC_TIME,"es_ES.UTF-8");
            $this->fecha_inicio_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_inicio));
            $this->fecha_final_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_final));
            $this->fecha_inicio_d_m = strftime("%A, %d de %B", strtotime($this->fecha_inicio));
            $this->fecha_final_d_m = strftime("%A, %d de %B", strtotime($this->fecha_final));
            $this->fecha_hoy = date("Y-m-d",strtotime($fecha_dia));

            $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_hoy));
            $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", strtotime($this->fecha_hoy));

            $this->fecha_dia_anterior = date('Y-m-d',strtotime($this->fecha_hoy. ' -1 day'));














            $this->fecha_hoy = date("Y-m-d");

            if($this->fecha == ""){
                $this->fecha = $this->fecha_hoy;
            }
            
        }

        for ($i=0; $i < 7 ; $i++) { 
            $this->array_fechas_semana[] = date('Y-m-d',strtotime($this->fecha_inicio. ' +'.  $i .' day'));
            //var_dump($i);
        }

            // var_dump($this->fecha_dia);
            // exit;

        // obtengo el primer y ultimo día de la semana según la fecha que nos encontramos

    }

    public  function obtenerFechaUnMes()
    {

        $dia = date("d");
        $mes = date("m");
        $año = date("Y");
      
        $this->fecha_inicio = date("Y-m-d",mktime(0,0,0,$mes,$dia - 30,$año));
        $this->fecha_final = date("Y-m-d"); 
        
        setlocale(LC_TIME,"es_ES.UTF-8");
        $this->fecha_inicio_mostrar = strftime("%A, %d de %B de %Y", mktime(0,0,0,$mes,$dia - 30,$año));
        $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", mktime(0,0,0,$mes,$dia,$año));


    }

    public  function ConfirmarSiEstaEntreRangos($fecha_comparar,$rango_inicial,$rango_final)
    {

        if ($fecha_comparar >= $rango_inicial && $fecha_comparar <= $rango_final) {
            return True;
        }else{
            return False;
        }

    }

    public  function obtenerFechaUnaSemana()
    {

        $dia = date("d");
        $mes = date("m");
        $año = date("Y");
      
        $this->fecha_inicio = date("Y-m-d",mktime(0,0,0,$mes,$dia - 7,$año));
        $this->fecha_final = date("Y-m-d"); 
        
        setlocale(LC_TIME,"es_ES.UTF-8");
        $this->fecha_inicio_mostrar = strftime("%A, %d de %B de %Y", mktime(0,0,0,$mes,$dia - 7,$año));
        $this->fecha_hoy_mostrar = strftime("%A, %d de %B de %Y", mktime(0,0,0,$mes,$dia,$año));


    }

    public  function arregloDiasAbilesEntreFechas()
    {

        $fecha_inicio = new \DateTime($this->fecha_inicio);
        $fecha_final = new \DateTime($this->fecha_final);

        while ($fecha_inicio <= $fecha_final) {

            $diaSemana=date("w",strtotime($fecha_inicio->format("Y-m-d")));

            if ($diaSemana != 0) {
                $arreglo_dia = [];
                $arreglo_dia['numero_dia'] = $diaSemana;
                $arreglo_dia['fecha'] = $fecha_inicio->format("Y-m-d");
                $this->array_fechas[] = $arreglo_dia;
            }

            $fecha_inicio = new \DateTime(date('Y-m-d', strtotime($fecha_inicio->format("Y-m-d"). ' +1 day')));

        }

    }

    public  function diasSemanaPorNumeroDia($hoy,$dia_acad)
    {

        $dia = date("d",strtotime($hoy));
        $mes = date("m",strtotime($hoy));
        $año = date("Y",strtotime($hoy));
        $diaSemana=date("w",strtotime($hoy));

        $fecha_inicio = date("Y-m-d",mktime(0,0,0,$mes,$dia - $diaSemana,$año));

        $this->fecha_dia = date('Y-m-d',strtotime($fecha_inicio. ' +' . $dia_acad . ' day'));




    }

}

?>

