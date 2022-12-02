<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PruebaCategoria as PruebaCategoriaModel;

/**
 * PruebaCategoria represents the model behind the search form about `common\models\PruebaCategoria`.
 */
class PruebaCategoria extends PruebaCategoriaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contiene_subramos', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'descripcion', 'codigo', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
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
        $query = PruebaCategoriaModel::find()->where(['activo'=>true])->orderBy(['id'=>SORT_ASC]);

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
            'contiene_subramos' => $this->contiene_subramos,
            'activo' => $this->activo,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
