<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;
use common\models\EmpresaHijo;
use common\models\UsuarioEmpresaHijo;
use yii\helpers\FileHelper;

/**
 * Esta es la clase de modelo para la tabla "empresa".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $empresa_tipo_id
 * @property string $descripcion
 * @property string $rut
 * @property string $razonsocial
 * @property string $direccion
 * @property string $telefono
 * @property string $imagen
 * @property string $rbd
 * @property string $sostenedor
 * @property string $director
 * @property string $encargadopw
 * @property string $telefonoepw
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class Empresa extends \yii\db\ActiveRecord
{

    public $filename;
    public $image;
    public $avatar;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['rut', 'empresa_tipo_id','activo','nombre'], 'required'],
            ['rut', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este usuario ya existe.','on'=>['validacionCompletaCrear']],
            ['rut', 'string', 'min' => 5, 'max' => 15],
            ['rut','validateRut'],

            [['empresa_tipo_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion', 'imagen'], 'string', 'max' => 300],
            [['razonsocial', 'direccion', 'sostenedor', 'director', 'encargadopw'], 'string', 'max' => 200],
            [['telefono', 'telefonoepw'], 'string', 'max' => 30],
            [['rbd'], 'string', 'max' => 45]
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
            'empresa_tipo_id' => 'Tipo Empresa',
            'descripcion' => 'Descripcion',
            'rut' => 'Rut',
            'razonsocial' => 'Razonsocial',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'imagen' => 'Imagen',
            'rbd' => 'Rbd',
            'sostenedor' => 'Sostenedor',
            'director' => 'Director',
            'encargadopw' => 'Encargadopw',
            'telefonoepw' => 'Telefonoepw',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }


    public function validateRut($attribute, $params)
    {

        if($this->$attribute == "11111111-1" || $this->$attribute == "22222222-2" || $this->$attribute == "33333333-3" || $this->$attribute == "44444444-4" || $this->$attribute == "55555555-5" || $this->$attribute == "66666666-6" || $this->$attribute == "77777777-7" || $this->$attribute == "88888888-8" || $this->$attribute == "99999999-9"  || $this->$attribute == "1-9" ){

            $this->addError($attribute, "Rut inválido.");
        }else{

            if(strlen($this->$attribute) < 1 || strlen($this->$attribute) > 10){  

                $this->addError($attribute, "Rut inválido.");
            }else{

                if(!preg_match("/[0-9]{5,8}[-][kK0-9]/", $this->$attribute)) {

                    $this->addError($attribute, "Rut inválido.");
                }else{

                    $name = strtoupper(preg_replace('/[^0-9kK]/','',(string) $this->$attribute));

                    $sub_rut=substr($name,0,strlen($name)-1);

                    $sub_dv=substr($name,-1);

                    $x=2;
                    $s=0;

                    for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
                    {
                        if ( $x >7 )
                        {
                            $x=2;
                        }
                        $s += $sub_rut[$i]*$x;
                        $x++;
                    }

                    $dv=11-($s%11);

                    if ( $dv==10 )
                    {
                        $dv='K';
                    }
                    if ( $dv==11 )
                    {
                        $dv='0';
                    }

                    if ( $dv!=$sub_dv )
                    {

                        $this->addError($attribute, "Rut inválido.");

                    }
                }
            }
        }

    }

    public static function getEmpresasNombre($id)
    {

        $Empresa = Empresa::findOne($id);  

        if($Empresa){
            return $Empresa->nombre;
        }else{
            return "";
        }

        

    }
    
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }



        // store the source file name
        $this->imagen = $image->name;



        $ext = explode(".", $image->name)[1];



        // generate a unique file name
        $this->avatar = "/empresa/" . $this->id . "/" .  $image->name;

        // the uploaded image instance
        return $image;
    }

    public function creoDirectorios($ruta) {
        $ruta = Yii::$app->params['uploadPath'] . $ruta;


        FileHelper::createDirectory($ruta);

    }

    public function getImageFile() 
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getEmpresas($id)
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 1])
        
        ->andWhere(['not', ['id'=>$id]])->all();

    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getColegiosCombo()
    {

        // $ramo =  ArrayHelper::map(Empresa::find()->where(['empresa.activo'=>true,'empresa_tipo_id'=>3,'curso.anio_id' => Yii::$app->user->identity->anio_predeterminado])
        // ->join('INNER JOIN', 'curso','curso.colegio_id =empresa.id')
        // ->all(), 'id', 'nombre') ;
         

        $data =  ArrayHelper::map(Empresa::find()->where(['empresa.activo'=>true,'empresa_tipo_id'=>3])
        //->join('INNER JOIN', 'curso','curso.colegio_id =empresa.id')
        ->all(), 'id', 'nombre') ;
         
        return $data ;


    }


    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getCorporaciones($id)
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 2])
        
        ->andWhere(['not', ['id'=>$id]])->all();

    }

    public static function getColegios($id)
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 3])
        
        ->andWhere(['not', ['id'=>$id]])->all();

    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getEmpresasExterno()
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 1,'activo' => 1])->all();

    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getCorporacionesExterno()
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 2,'activo' => 1])->all();

    }

    public static function getColegiosExterno()
    {

        return Empresa::find()
        
        ->where(['empresa_tipo_id' => 3,'activo' => 1])->all();

    }


    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargados($EmpresaPrinicipal,$EmpresaHijo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = EmpresaHijo::find()->where(['padre_id' => $EmpresaPrinicipal,'hijo_id' => $EmpresaHijo,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* asignamos este subRol al rol principal  */
    public static function asignarHijo($hijoid,$hijoname,$padreid,$padrename)
    {

        $EmpresaHijo = new EmpresaHijo();

        $EmpresaHijo->padre_id = $padreid;
        $EmpresaHijo->nombre_padre = $padrename;
        $EmpresaHijo->hijo_id = $hijoid;
        $EmpresaHijo->nombre_hijo = $hijoname;
        $EmpresaHijo->activo = 1;
        $EmpresaHijo->creado_por = Yii::$app->user->identity->id;
        $EmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");
        $EmpresaHijo->save();



    }

    /* Eliminamos este subRol al rol principal  */
    public static function eliminarHijo($padreid,$hijoid)
    {

        $EmpresaHijo = EmpresaHijo::find()->where(['padre_id' => $padreid,'hijo_id' => $hijoid,'activo' => 1])->one();

        $EmpresaHijo->activo = 0;
        
        $EmpresaHijo->save();
        
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getEmpresaTipo()
    {
        return $this->hasOne(EmpresaTipo::className(),['id'=>'empresa_tipo_id']);
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getEmpresaTipoCombo()
    {
        $data =  ArrayHelper::map(EmpresaTipo::find()->where(['activo'=>true])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

    public static function getColegiosAsignadosUsuario($id_usuario)
    {

        $arreglo_colegos_buscar = [];

        // busco los asignados

        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        
        ->where(['activo' => 1,'usuario_id' => $id_usuario])
        
        ->all();


        foreach ($UsuarioEmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->empresa_id;
        }

        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();

        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }

        // busco una segnda relación 
        
        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();

        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }

        $Empresa = Empresa::find()
        
        ->where(['empresa_tipo_id' => 3,'activo' => 1,'id' => $arreglo_colegos_buscar])
        ->asArray()
        ->all();



        return $Empresa;



    }

    public static function getColegiosAsignadosUsuarioCombo($id_usuario)
    {

        $arreglo_colegos_buscar = [];

        // busco los asignados

        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        
        ->where(['activo' => 1,'usuario_id' => $id_usuario])
        
        ->all();



        foreach ($UsuarioEmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->empresa_id;
        }

        

        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();



        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }



        // busco una segnda relación 
        
        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();

        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }



        $Empresa = Empresa::find()
        
        ->where(['empresa_tipo_id' => 3,'activo' => 1,'id' => $arreglo_colegos_buscar])
        ->asArray()
        ->all();



        $data =  ArrayHelper::map($Empresa, 'id', 'nombre') ;

        return $data ;    

        // return $Empresa;



    }

    public static function getEmpresasAsignadosUsuario($id_usuario)
    {

        $arreglo_colegos_buscar = [];

        // busco los asignados

        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        
        ->where(['activo' => 1,'usuario_id' => $id_usuario])
        
        ->all();
        


        foreach ($UsuarioEmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] =  $value->empresa_id;
        }


        
        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();



        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }


        // busco una segnda relación 
        
        $EmpresaHijo = EmpresaHijo::find()
        
        ->where(['activo' => 1,'hijo_id' => $arreglo_colegos_buscar])
        
        ->all();



        foreach ($EmpresaHijo as $key => $value) {
            $arreglo_colegos_buscar[] = $value->padre_id;
        }




        return $arreglo_colegos_buscar;



    }

    public static function AssignUsuarioEmpresa($empresaid,$usuarioid)
    {


        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        ->where(['usuario_id' => $usuarioid,'empresa_id' => $empresaid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();




        if(!$UsuarioEmpresaHijo){

            $UsuarioEmpresaHijo = new UsuarioEmpresaHijo();
            $UsuarioEmpresaHijo->empresa_id = $empresaid;
            $UsuarioEmpresaHijo->usuario_id = $usuarioid;
            $UsuarioEmpresaHijo->creado_por = Yii::$app->user->identity->id;
            $UsuarioEmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");
            $UsuarioEmpresaHijo->activo = 1;



            $UsuarioEmpresaHijo->save();

        }else{

            $UsuarioEmpresaHijo->activo = 0;

            $UsuarioEmpresaHijo->save();

        }


    }

}
