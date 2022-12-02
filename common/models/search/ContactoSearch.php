<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contacto;

/**
 * ContactoSearch represents the model behind the search form of `common\models\Contacto`.
 */
class ContactoSearch extends Contacto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'respondido_por'], 'integer'],
            [['nombre', 'email', 'telefono', 'descripcion', 'fecha_creacion', 'respuesta', 'fecha_modificacion', 'estado'], 'safe'],
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
        $query = Contacto::find()->where(['activo'=>true])->orderBy(['id'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'fecha_creacion' => $this->fecha_creacion,
            'respondido_por' => $this->respondido_por,
            'fecha_modificacion' => $this->fecha_modificacion,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'respuesta', $this->respuesta])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
