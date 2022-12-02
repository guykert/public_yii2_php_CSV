<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Prueba as PruebaModel;

/**
 * Prueba represents the model behind the search form about `common\models\Prueba`.
 */
class Prueba extends PruebaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prueba_categoria_id', 'ramo_id', 'sub_ramo_id', 'muestra_resultados_web', 'creado_por', 'modificado_por', 'formula_id', 'tabla_conversion_id', 'tiempo', 'externo_id', 'migrar', 'solucionario_teorico_id', 'solucionario_id', 'numero_preguntas', 'mostrar_escaner', 'migrar_pauta', 'mension_comun', 'anio_id'], 'integer'],
            [['nombre', 'codigo', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
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
        $query = PruebaModel::find()->where(['activo'=>true,'empresa_id'=>Yii::$app->user->identity->colegio_predeterminada,'anio_id'=>Yii::$app->user->identity->anio_predeterminado])->orderBy(['id'=>SORT_ASC]);

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
            'prueba_categoria_id' => $this->prueba_categoria_id,
            'ramo_id' => $this->ramo_id,
            'sub_ramo_id' => $this->sub_ramo_id,
            'muestra_resultados_web' => $this->muestra_resultados_web,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
            'activo' => $this->activo,
            'formula_id' => $this->formula_id,
            'tabla_conversion_id' => $this->tabla_conversion_id,
            'tiempo' => $this->tiempo,
            'externo_id' => $this->externo_id,
            'migrar' => $this->migrar,
            'solucionario_teorico_id' => $this->solucionario_teorico_id,
            'solucionario_id' => $this->solucionario_id,
            'numero_preguntas' => $this->numero_preguntas,
            'mostrar_escaner' => $this->mostrar_escaner,
            'migrar_pauta' => $this->migrar_pauta,
            'mension_comun' => $this->mension_comun,
            'anio_id' => $this->anio_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
