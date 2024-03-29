<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Account;

/**
 * AccountSearch represents the model behind the search form of `backend\models\Account`.
 */
class AccountSearch extends Account
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_provider_id', 'company_id', 'branch_id','is_cash_account'], 'integer'],
            [['name', 'account_no', 'agent_no', 'maker', 'maker_time'], 'safe'],
            [['initial_balance'], 'number'],
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
        $query = Account::find();

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
            'service_provider_id' => $this->service_provider_id,
            'company_id' => $this->company_id,
            'branch_id' => $this->branch_id,
            'is_cash_account' => $this->is_cash_account,
            'initial_balance' => $this->initial_balance,
            'maker_time' => $this->maker_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'agent_no', $this->agent_no])
            ->andFilterWhere(['like', 'maker', $this->maker]);

        return $dataProvider;
    }
}
