<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SalesAgent;

/**
 * SalesAgentSearch represents the model behind the search form of `backend\models\SalesAgent`.
 */
class SalesAgentSearch extends SalesAgent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['agent_name', 'agent_code', 'mobile_number', 'email_address', 'maker', 'maker_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = SalesAgent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'maker_time' => $this->maker_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'agent_name', $this->agent_name])
            ->andFilterWhere(['like', 'agent_code', $this->agent_code])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'maker', $this->maker]);

        return $dataProvider;
    }
}
