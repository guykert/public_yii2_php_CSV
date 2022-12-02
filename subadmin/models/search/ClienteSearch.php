<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form of `backend\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'edad', 'clave_actualizada', 'status', 'updated_at', 'creado_por', 'created_at', 'modificado_por', 'rol_predeterminado', 'anio_predeterminado'], 'integer'],
            [['rut', 'nombre', 'apellido_paterno', 'apellido_materno', 'sexo', 'email', 'email2', 'telefono1', 'telefono2', 'username', 'auth_key', 'password_reset_token', 'password_hash', 'fecha_creacion', 'fecha_modificacion', 'passwordResetTokenExpire'], 'safe'],
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
        $query = Cliente::find()->where(['usuario.activo'=>true,'rol_usuario.item_name'=>'cliente'])
                    ->join('INNER JOIN','rol_usuario','rol_usuario.user_id =usuario.id') ;
  

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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

        // grid filtering conditions
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
            ->andFilterWhere(['like', 'passwordResetTokenExpire', $this->passwordResetTokenExpire]);

        return $dataProvider;
    }
}
