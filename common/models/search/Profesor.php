<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Profesor as ProfesorModel;

/**
 * Profesor represents the model behind the search form about `common\models\Profesor`.
 */
class Profesor extends ProfesorModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'edad', 'clave_actualizada', 'status', 'updated_at', 'creado_por', 'created_at', 'modificado_por', 'rol_predeterminado', 'anio_predeterminado', 'colegio_predeterminada', 'template_predeterminado'], 'integer'],
            [['rut', 'nombre', 'apellido_paterno', 'apellido_materno', 'sexo', 'email', 'email2', 'telefono1', 'telefono2', 'username', 'auth_key', 'password_reset_token', 'password_hash', 'fecha_creacion', 'fecha_modificacion', 'passwordResetTokenExpire', 'nombre_scanner_predeterminado'], 'safe'],
            [['activo'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // $query = ProfesorModel::find()
        // ->where(['usuario.activo'=>true,'rol_usuario.item_name'=>'profesor'])->orderBy(['id'=>SORT_ASC]);

        $query = ProfesorModel::find()
        
        ->where(['usuario.activo'=>true,'rol_usuario.item_name'=>'profesor','usuario_empresa_hijo.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->join('INNER JOIN', 'usuario_empresa_hijo','usuario_empresa_hijo.usuario_id =usuario.id and usuario_empresa_hijo.activo = 1') 
        
        ->orderBy(['id'=>SORT_ASC]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('rolProfesor');

        $query->andFilterWhere([
            'id' => $this->id,
            'edad' => $this->edad,
            'clave_actualizada' => $this->clave_actualizada,
            'status' => $this->status,
            'activo' => $this->activo,
            'updated_at' => $this->updated_at,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_modificacion' => $this->fecha_modificacion,
            'creado_por' => $this->creado_por,
            'created_at' => $this->created_at,
            'modificado_por' => $this->modificado_por,
            'rol_predeterminado' => $this->rol_predeterminado,
            'anio_predeterminado' => $this->anio_predeterminado,
            'colegio_predeterminada' => $this->colegio_predeterminada,
            'template_predeterminado' => $this->template_predeterminado,
        ]);

        $query->andFilterWhere(['like', 'rut', $this->rut])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'email2', $this->email2])
            ->andFilterWhere(['like', 'telefono1', $this->telefono1])
            ->andFilterWhere(['like', 'telefono2', $this->telefono2])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'passwordResetTokenExpire', $this->passwordResetTokenExpire])
            ->andFilterWhere(['like', 'nombre_scanner_predeterminado', $this->nombre_scanner_predeterminado]);

        return $dataProvider;
    }
}
