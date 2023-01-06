<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AgentJournalEntry;

/**
 * AgentJournalEntrySearch represents the model behind the search form of `backend\models\AgentJournalEntry`.
 */
class AgentJournalEntrySearch extends AgentJournalEntry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'branch_id', 'company_id', 'is_reversed'], 'integer'],
            [['trn_dt', 'description', 'receipt','total_money_in', 'total_money_out', 'maker_id', 'maker_time', 'auth_stat', 'checker_id', 'checker_time'], 'safe'],
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
        $query = AgentJournalEntry::find();

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
            'trn_dt' => $this->trn_dt,
            'agent_id' => $this->agent_id,
            'branch_id' => $this->branch_id,
            'company_id' => $this->company_id,
            'maker_time' => $this->maker_time,
            'is_reversed' => $this->is_reversed,
            'checker_time' => $this->checker_time,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'receipt', $this->receipt])
            ->andFilterWhere(['like', 'maker_id', $this->maker_id])
            ->andFilterWhere(['like', 'auth_stat', $this->auth_stat])
            ->andFilterWhere(['like', 'checker_id', $this->checker_id]);

        return $dataProvider;
    }
}
