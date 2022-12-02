<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Empresa as EmpresaModel;

/**
 * Empresa represents the model behind the search form about `common\models\Empresa`.
 */
class Empresa extends EmpresaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'empresa_tipo_id', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'descripcion', 'rut', 'razonsocial', 'direccion', 'telefono', 'imagen', 'rbd', 'sostenedor', 'director', 'encargadopw', 'telefonoepw', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
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
        $query = EmpresaModel::find()->where(['activo'=>true])->orderBy(['id'=>SORT_ASC]);

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

        $query->andFilterWhere([
            'id' => $this->id,
            'empresa_tipo_id' => $this->empresa_tipo_id,
            'activo' => $this->activo,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'rut', $this->rut])
            ->andFilterWhere(['like', 'razonsocial', $this->razonsocial])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'rbd', $this->rbd])
            ->andFilterWhere(['like', 'sostenedor', $this->sostenedor])
            ->andFilterWhere(['like', 'director', $this->director])
            ->andFilterWhere(['like', 'encargadopw', $this->encargadopw])
            ->andFilterWhere(['like', 'telefonoepw', $this->telefonoepw]);

        return $dataProvider;
    }
}
