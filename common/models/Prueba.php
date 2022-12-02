<?php

namespace common\models;


use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * Esta es la clase de modelo para la tabla "prueba".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo
 * @property integer $prueba_categoria_id
 * @property integer $ramo_id
 * @property integer $sub_ramo_id
 * @property integer $muestra_resultados_web
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 * @property integer $formula_id
 * @property integer $tabla_conversion_id
 * @property integer $tiempo
 * @property integer $externo_id
 * @property integer $migrar
 * @property integer $solucionario_teorico_id
 * @property integer $solucionario_id
 * @property integer $numero_preguntas
 * @property integer $mostrar_escaner
 * @property integer $migrar_pauta
 * @property integer $mension_comun
 * @property integer $anio_id
 */

class Prueba extends \yii\db\ActiveRecord
{

    public $ruta_archivo1;
    public $filename;
    public $avatar;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prueba_categoria_id', 'ramo_id', 'sub_ramo_id', 'muestra_resultados_web', 'creado_por', 'modificado_por', 'formula_id', 'tabla_conversion_id', 'tiempo', 'externo_id', 'migrar', 'solucionario_teorico_id', 'solucionario_id', 'numero_preguntas', 'mostrar_escaner', 'migrar_pauta', 'mension_comun', 'anio_id'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion','nivel_id','pagina_alumno_id','pagina_alumno_area_id','cantidad_minutos','cantidad_intentos','fecha_mostrar_prueba','fecha_mostrar_solucionario','fecha_terminar_prueba','fecha_terminar_solucionario','curso_id'], 'safe'],
            [['creado_por','nivel_id', 'ramo_id', 'sub_ramo_id'], 'required'],

            [['nombre','prueba_ruta_archivo'], 'required','on'=>['formProfesor']],


            
            [['activo'], 'boolean'],
            [['nombre'], 'string', 'max' => 150],
            [['codigo'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
            'prueba_categoria_id' => 'Categoría',
            'ramo_id' => 'Ramo',
            'sub_ramo_id' => 'Sub Ramo',
            'muestra_resultados_web' => 'Muestra Resultados Web',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
            'formula_id' => 'Formula',
            'tabla_conversion_id' => 'Tabla Conversion',
            'tiempo' => 'Tiempo',
            'externo_id' => 'Externo',
            'migrar' => 'Migrar',
            'solucionario_teorico_id' => 'Solucionario Teorico',
            'solucionario_id' => 'Solucionario',
            'numero_preguntas' => 'Numero Preguntas',
            'mostrar_escaner' => 'Mostrar Escaner',
            'migrar_pauta' => 'Migrar Pauta',
            'mension_comun' => 'Mension Comun',
            'anio_id' => 'Anio',
            'nivel_id' => 'Nivel',
            'cantidad_intentos' => 'Cantidad de Intentos',
        ];
    }

    public function scenarios()
    {

        $scenarios = parent::scenarios();

        $scenarios['formProfesor'] = ['nombre', 'numero_preguntas','prueba_ruta_archivo','curso_id'];

        $scenarios['configuraciones'] = ['prueba_categoria_id', 'fecha_mostrar_prueba','cantidad_minutos','fecha_terminar_prueba','cantidad_intentos'];

        $scenarios['delete'] = ['activo'];

        return $scenarios;

    } 
 
    public static function getCondisional()
    {
        $bloque =  ['1' => 'SI','0' => 'NO'];
        return $bloque ;
    }

    /**
        * Process upload of image
        *
        * @return mixed the uploaded image instance
    */
    public function uploadPrueba() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $ruta_archivo1 = UploadedFile::getInstance($this, 'ruta_archivo1');

        // if no image was uploaded abort the upload
        if (empty($ruta_archivo1)) {
            return false;
        }



        // store the source file name
        $this->filename = $ruta_archivo1->name;



        $ext = explode(".", $ruta_archivo1->name)[1];



        // generate a unique file name
        $this->avatar = "pruebas/" . Yii::$app->user->identity->id."/" . $ruta_archivo1->name;




        return $ruta_archivo1;
    }

    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getPruebaFile() 
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    public function creoDirectorios() {
        $ruta = Yii::$app->params['uploadPath'] . "/pruebas/" . Yii::$app->user->identity->id;


        FileHelper::createDirectory($ruta);

    }

    /* función para cargar la Lista de código de cursos*/
    public static function getNumero()
    {

            $bloque =  ['1' => '01','2' => '02','3' => '03','4' => '04','5' => '05','6' => '06','7' => '07','8' => '08','9' => '09','10' => '10',
                        '11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '19','20' => '20',
                        '21' => '21','22' => '22','23' => '23','24' => '24','25' => '25','26' => '26','27' => '27','28' => '28','29' => '29','30' => '30',
                        '31' => '31','32' => '32','33' => '33','34' => '34','35' => '35','36' => '36','37' => '37','38' => '38','39' => '39','40' => '40',
                        '41' => '41','42' => '42','43' => '43','44' => '44','45' => '45','46' => '46','47' => '47','48' => '48','49' => '49','50' => '50',
                        '51' => '51','52' => '52','53' => '53','54' => '54','55' => '55','56' => '56','57' => '57','58' => '58','59' => '59','60' => '60',
                        '61' => '61','62' => '62','63' => '63','64' => '64','65' => '65','66' => '66','67' => '67','68' => '68','69' => '69','70' => '70',
                        '71' => '71','72' => '72','73' => '73','74' => '74','75' => '75','76' => '76','77' => '77','78' => '78','79' => '79','80' => '80',
                        '81' => '81','82' => '82','83' => '83','84' => '84','85' => '85','86' => '86','87' => '87','88' => '88','89' => '89','90' => '90',
                        '91' => '91','92' => '92','93' => '93','94' => '94','95' => '95','96' => '96','97' => '97','98' => '98','99' => '99','100' => '100',
                        '101' => '101','102' => '102','103' => '103','104' => '104','105' => '105','106' => '106','107' => '107','108' => '108','109' => '109','110' => '110',
                        '111' => '111','112' => '112','113' => '113','114' => '114','115' => '115','116' => '116','117' => '117','118' => '118','119' => '119','120' => '120'];
         return $bloque ;
    }

    public function getRamo()
    {
        return $this->hasOne(Ramo::className(), ['id'=>'ramo_id']);
    }

    public function getPruebaCategoria()
    {
        return $this->hasOne(PruebaCategoria::className(), ['id'=>'prueba_categoria_id']);
    }

    public function getCategoria()
    {
        return $this->hasOne(PruebaCategoria::className(), ['id'=>'prueba_categoria_id']);
    }

    public function getSubRamo()
    {
        return $this->hasOne(SubRamo::className(), ['id'=>'sub_ramo_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getNivel()
    {
        return $this->hasOne(Nivel::className(),['id'=>'nivel_id']);
    }

    public static function getActivoPruebasComboDependiente($id_nivel,$id_ramo,$id_categoria_prueba)
    {

        $Prueba  = Prueba::find()
                    ->where(['prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada, 'prueba.activo'=> true])
                    ->select(['prueba.id as id','prueba.nombre as name']);

        if($id_nivel != ""){

            $Prueba->andWhere(['prueba.nivel_id'=>$id_nivel]);

        }
        
        if($id_ramo != ""){

            $Prueba->andWhere(['ramo_id'=>$id_ramo]);
            
        }
         
        if($id_categoria_prueba != ""){

            $Prueba->andWhere(['prueba_categoria_id'=>$id_categoria_prueba]);
            
        }

        $Prueba  = $Prueba->asArray()
                    ->all() ;

        return $Prueba ;

    }

    public static function getActivoPruebasColegio($id_empresa_origen)
    {

        $Prueba  = Prueba::find()
                    ->where(['prueba.empresa_id'=>$id_empresa_origen, 'prueba.activo'=> true])
                    ->select(['prueba.id as id','prueba.nombre as name']);


        $Prueba  = $Prueba->asArray()
                    ->all() ;

        return $Prueba ;

    }

    /* rescara las preguntas de una prueba */
    public function getPreguntasPrueba()
    {
        $MdlilQuizQuestionInstances= MdlilQuizQuestionInstances::find()->where(['quiz'=>$this->externo_id])
        ->orderBy(['numero_pregunta'=>SORT_ASC])
        ->All();


        return $MdlilQuizQuestionInstances;
    }

    /* rescara las preguntas de una prueba */
    public function getPreguntasSolucionario()
    {
        $MdlilQuizQuestionInstances= MdlilQuizQuestionInstances::find()->where(['quiz'=>$this->solucionario_id])
        ->orderBy(['numero_pregunta'=>SORT_ASC])
        ->All();



        return $MdlilQuizQuestionInstances;
    }

    /* rescara las preguntas de una prueba */
    public function getPreguntasCorrectas()
    {
        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$this->id,'activo'=>1])->asArray()->All();

        return ArrayHelper::index($PruebaPauta, 'numero_pregunta');
    }

    /* rescara las preguntas de una prueba */
    public static function getPruebasColegioSearch()
    {


        $data =  ArrayHelper::map(Prueba::find()->where(['activo'=>true,'empresa_id'=>Yii::$app->user->identity->colegio_predeterminada,'anio_id'=>Yii::$app->user->identity->anio_predeterminado])
        ->orderBy('nombre')->all(), 'id', 'nombre') ;

        return $data ; 
    }

}
