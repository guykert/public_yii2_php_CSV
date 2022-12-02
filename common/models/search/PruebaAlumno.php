<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PruebaAlumno as PruebaAlumnoModel;

/**
 * PruebaAlumno represents the model behind the search form about `common\models\PruebaAlumno`.
 */
class PruebaAlumno extends PruebaAlumnoModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sede_id', 'prueba_id', 'curso_id', 'nota', 'buenas', 'malas', 'omitidas', 'creado_por', 'modificado_por', 'tiempo_pausa', 'id_ensayo_desafio', 'id_tipo_desafio', 'mdl_quiz_id', 'mdl_attempt', 'empresa_id', 'neto', 'porcentaje_logro', 'nivel_logro', 'pond_buenas', 'pond_malas', 'pond_omitidas', 'preguntas_abiertas'], 'integer'],
            [['rut', 'fecha_creacion', 'fecha_modificacion', 'fecha_termino', 'fecha_inicio', 'fecha_pausa', 'detalle_malas', 'descripcion', 'observacion'], 'safe'],
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
        $query = PruebaAlumnoModel::find()->where(['prueba_alumno.activo'=>true,'prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada,'prueba.anio_id'=>Yii::$app->user->identity->anio_predeterminado])
        ->join('INNER JOIN','prueba','prueba.id =prueba_alumno.prueba_id')
        ->orderBy(['prueba_alumno.id'=>SORT_ASC]);

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
            'sede_id' => $this->sede_id,
            'prueba_id' => $this->prueba_id,
            'curso_id' => $this->curso_id,
            'nota' => $this->nota,
            'buenas' => $this->buenas,
            'malas' => $this->malas,
            'omitidas' => $this->omitidas,
            'fecha_creacion' => $this->fecha_creacion,
            'creado_por' => $this->creado_por,
            'fecha_modificacion' => $this->fecha_modificacion,
            'modificado_por' => $this->modificado_por,
            'activo' => $this->activo,
            'fecha_termino' => $this->fecha_termino,
            'fecha_inicio' => $this->fecha_inicio,
            'tiempo_pausa' => $this->tiempo_pausa,
            'fecha_pausa' => $this->fecha_pausa,
            'id_ensayo_desafio' => $this->id_ensayo_desafio,
            'id_tipo_desafio' => $this->id_tipo_desafio,
            'mdl_quiz_id' => $this->mdl_quiz_id,
            'mdl_attempt' => $this->mdl_attempt,
            'empresa_id' => $this->empresa_id,
            'neto' => $this->neto,
            'porcentaje_logro' => $this->porcentaje_logro,
            'nivel_logro' => $this->nivel_logro,
            'pond_buenas' => $this->pond_buenas,
            'pond_malas' => $this->pond_malas,
            'pond_omitidas' => $this->pond_omitidas,
            'preguntas_abiertas' => $this->preguntas_abiertas,
        ]);

        $query->andFilterWhere(['like', 'rut', $this->rut])
            ->andFilterWhere(['like', 'detalle_malas', $this->detalle_malas])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
