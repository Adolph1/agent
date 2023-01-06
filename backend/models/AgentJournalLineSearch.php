<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AgentJournalLine;

/**
 * AgentJournalLineSearch represents the model behind the search form of `backend\models\AgentJournalLine`.
 */
class AgentJournalLineSearch extends AgentJournalLine
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'journal_id', 'branch_id', 'account_id', 'status'], 'integer'],
            [['trn_dt', 'trn_type', 'created_by', 'created_at'], 'safe'],
            [['money_in', 'money_out'], 'number'],
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
        $query = AgentJournalLine::find();

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
            'journal_id' => $this->journal_id,
            'branch_id' => $this->branch_id,
            'account_id' => $this->account_id,
            'money_in' => $this->money_in,
            'money_out' => $this->money_out,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'trn_type', $this->trn_type])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
