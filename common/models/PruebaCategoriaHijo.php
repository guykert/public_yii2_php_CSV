<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_categoria_hijo".
 *
 * @property integer $id
 * @property integer $empresa_id
 * @property integer $categoria_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PruebaCategoriaHijo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_categoria_hijo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['empresa_id', 'categoria_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresa_id' => 'Empresa ID',
            'categoria_id' => 'Categoria ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

        /* consulto si el usuario tiene asignado el rol  */
        public static function getConfirnarAsignados($idEmpresa,$categoriaID)
        {
    
            // consulto si este Empresa tiene asignado el rol
    
            $data = PruebaCategoriaHijo::find()->where(['empresa_id' => $idEmpresa,'categoria_id' => $categoriaID,'activo' => 1])->count();
    
            if($data > 0){
                return true;
            }else{
                return false;
            }
            
        }
}
