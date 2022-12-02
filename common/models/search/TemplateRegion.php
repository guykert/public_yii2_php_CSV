<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TemplateRegion as TemplateRegionModel;

/**
 * TemplateRegion represents the model behind the search form about `common\models\TemplateRegion`.
 */
class TemplateRegion extends TemplateRegionModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'template_id', 'tipo_elemento_id', 'x', 'y', 'width', 'height', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'descripcion', 'respuesta', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
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
        $query = TemplateRegionModel::find()->where(['activo'=>true])->orderBy(['id'=>SORT_ASC]);

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
            'template_id' => $this->template_id,
            'tipo_elemento_id' => $this->tipo_elemento_id,
            'x' => $this->x,
            'y' => $this->y,
            'width' => $this->width,
            'height' => $this->height,
            'activo' => $this->activo,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'respuesta', $this->respuesta]);

        return $dataProvider;
    }
}
