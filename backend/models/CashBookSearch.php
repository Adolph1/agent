<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CashBook;

/**
 * CashBookSearch represents the model behind the search form of `backend\models\CashBook`.
 */
class CashBookSearch extends CashBook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'branch_id', 'product_id','transaction_account_id', 'money_in_account', 'money_out_account', 'trn_stat'], 'integer'],
            [['product_code', 'trn_dt', 'description', 'period', 'year', 'maker', 'maker_time'], 'safe'],
            [['in_amount', 'out_amount','transaction_amount'], 'number'],
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
        if(\Yii::$app->user->can('BusinessOwner')) {
            $query = CashBook::find();
            $query->where(['in','branch_id',Branch::getOwnerBranchIds()]);
            $query->orderBy(['trn_dt' => SORT_DESC]);

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
                'branch_id' => $this->branch_id,
                'product_id' => $this->product_id,
                'trn_dt' => $this->trn_dt,
                'money_in_account' => $this->money_in_account,
                'money_out_account' => $this->money_out_account,
                'transaction_account_id' => $this->transaction_account_id,
                'in_amount' => $this->in_amount,
                'out_amount' => $this->out_amount,
                'transaction_amount' => $this->transaction_amount,
                'maker_time' => $this->maker_time,
                'trn_stat' => $this->trn_stat,
            ]);

            $query->andFilterWhere(['like', 'product_code', $this->product_code])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'period', $this->period])
                ->andFilterWhere(['like', 'year', $this->year])
                ->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }elseif (\Yii::$app->user->can('BranchManager')){
            $query = CashBook::find();
            $query->where(['in','branch_id',Branch::getMyBranchId()]);
            $query->orderBy(['trn_dt' => SORT_DESC]);

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
                'branch_id' => $this->branch_id,
                'product_id' => $this->product_id,
                'trn_dt' => $this->trn_dt,
                'money_in_account' => $this->money_in_account,
                'money_out_account' => $this->money_out_account,
                'transaction_account_id' => $this->transaction_account_id,
                'in_amount' => $this->in_amount,
                'out_amount' => $this->out_amount,
                'transaction_amount' => $this->transaction_amount,
                'maker_time' => $this->maker_time,
                'trn_stat' => $this->trn_stat,
            ]);

            $query->andFilterWhere(['like', 'product_code', $this->product_code])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'period', $this->period])
                ->andFilterWhere(['like', 'year', $this->year])
                ->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }else{
            $query = CashBook::find();
            $query->orderBy(['trn_dt' => SORT_DESC]);

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
                'branch_id' => $this->branch_id,
                'product_id' => $this->product_id,
                'trn_dt' => $this->trn_dt,
                'money_in_account' => $this->money_in_account,
                'money_out_account' => $this->money_out_account,
                'transaction_account_id' => $this->transaction_account_id,
                'in_amount' => $this->in_amount,
                'out_amount' => $this->out_amount,
                'transaction_amount' => $this->transaction_amount,
                'maker_time' => $this->maker_time,
                'trn_stat' => $this->trn_stat,
            ]);

            $query->andFilterWhere(['like', 'product_code', $this->product_code])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'period', $this->period])
                ->andFilterWhere(['like', 'year', $this->year])
                ->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }
    }

    public function searchSummary($params)
    {
        $query = CashBook::find();
        $query->groupBy('trn_dt');

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
            'branch_id' => $this->branch_id,
            'product_id' => $this->product_id,
            'trn_dt' => $this->trn_dt,
            'money_in_account' => $this->money_in_account,
            'money_out_account' => $this->money_out_account,
            'transaction_account_id' => $this->transaction_account_id,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'transaction_amount' => $this->transaction_amount,
            'maker_time' => $this->maker_time,
            'trn_stat' => $this->trn_stat,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'maker', $this->maker]);

        return $dataProvider;
    }
}
