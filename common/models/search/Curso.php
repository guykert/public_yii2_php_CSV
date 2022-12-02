<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Curso as CursoModel;

/**
 * Curso represents the model behind the search form about `common\models\Curso`.
 */
class Curso extends CursoModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'colegio_id', 'capacidad', 'cupo', 'creado_por', 'modificado_por', 'anio_id'], 'integer'],
            [['codigo', 'nombre', 'descripcion', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
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
        $query = CursoModel::find()->where(['activo'=>true,'colegio_id'=>Yii::$app->user->identity->colegio_predeterminada,'anio_id'=>Yii::$app->user->identity->anio_predeterminado])->orderBy(['id'=>SORT_ASC]);

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
            'colegio_id' => $this->colegio_id,
            'capacidad' => $this->capacidad,
            'cupo' => $this->cupo,
            'activo' => $this->activo,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
            'anio_id' => $this->anio_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
