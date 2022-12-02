<?php
namespace common\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * Password reset form
 */
class FormSettings extends User
{
    public $password;

    public $password_repeat;

    public $rol_predeterminado;

    public $sede_predeterminada;

    public $anio_predeterminado;

    public $colegio_predeterminada;

    public $image;

    public $filename;

    public $avatar;
    

    public $fbimageprofile;

    /**
     * @var \common\models\User
     */
    private $_user;

    public function __construct()
    {

        $this->_user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'id' => Yii::$app->user->identity->id,
        ]);

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            // [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            ['password','string', 'min' => 6,'message'=>'El password tiene que tener minimo 6 caracteres'],
            ['password', 'compare'],//password_repeat
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden'],
            [['password','sede_predeterminada','rol_predeterminado','image','filename','avatar','colegio_predeterminada'],'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

     public function attributeLabels()
    {
        return [
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir Contraseña',
            'anio_predeterminado' => 'Año Predeterminada',

        ];
    }
 

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */


    public function resetPassword($cantidadSedesUsuario,$cantidadRolesUsuario)
    {



        $user = $this->_user;
        

        if(!$this->password == ""){

            $user->setPassword($this->password);

        }


        if($cantidadSedesUsuario > 1 && !$this->sede_predeterminada){

            $this->addError('sede_predeterminada', 'El campo Sede es obligatorio');

        }else{

            if($this->sede_predeterminada != ""){
                $user->sede_predeterminada = $this->sede_predeterminada;
            }

        }

        $user->anio_predeterminado = $this->anio_predeterminado;


        if($cantidadRolesUsuario > 1 && !$this->rol_predeterminado){

            $this->addError('rol_predeterminado', 'El campo Rol es obligatorio');

        }else{

            if($this->rol_predeterminado != ""){
                $user->rol_predeterminado = $this->rol_predeterminado;
            }

        }

        if (!$this->errors) {

            return $user->save(false);
        }        
    }

    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $avatar;
    }

    public function getImageUrl2() 
    {

        $user = $this->_user;

        // $path = utf8_decode(Yii::getAlias('@frontend').$user->image_name);
        $path = Yii::getAlias('@perfiles')."/".$user->image_name;


        // return a default image placeholder if your source avatar is not found
        $avatar = isset($user->image) ? $path : Yii::$app->params['uploadUrl'] . 'default_user.jpg';
        return $avatar;
    }

    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
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
        $this->filename = $image->name;



        $ext = explode(".", $image->name)[1];



        // generate a unique file name
        $this->avatar = Yii::$app->user->identity->id."/profile/" . $image->name;

        // the uploaded image instance
        return $image;
    }

    public function creoDirectorios() {
        $ruta = Yii::$app->params['uploadPath'] . "/" . Yii::$app->user->identity->id."/profile/";


        FileHelper::createDirectory($ruta);

    }

    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }

}
