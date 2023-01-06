<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MoneyTransfer;

/**
 * MoneyTransferSearch represents the model behind the search form of `backend\models\MoneyTransfer`.
 */
class MoneyTransferSearch extends MoneyTransfer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'from_branch_id', 'to_branch_id','status','account_id'], 'integer'],
            [['trn_dt', 'description', 'requested_by', 'requested_time', 'accepted_by', 'accepted_time'], 'safe'],
            [['amount'], 'number'],
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
        if(\Yii::$app->user->can('BranchManager')) {


            $query = MoneyTransfer::find();
            $query->where(['from_branch_id' => Branch::getMyBranchId()]);
            $query->orWhere(['to_branch_id' => Branch::getMyBranchId()]);
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
                'trn_dt' => $this->trn_dt,
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
                'account_id' => $this->account_id,
                'status' => $this->status,
                'amount' => $this->amount,
                'requested_time' => $this->requested_time,
                'accepted_time' => $this->accepted_time,
            ]);

            $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'requested_by', $this->requested_by])
                ->andFilterWhere(['like', 'accepted_by', $this->accepted_by]);

            return $dataProvider;
        }elseif (\Yii::$app->user->can('BusinessOwner')){


            $query = MoneyTransfer::find();
            $query->where(['in','from_branch_id',Branch::getOwnerBranchIds()]);
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
                'trn_dt' => $this->trn_dt,
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
                'account_id' => $this->account_id,
                'status' => $this->status,
                'amount' => $this->amount,
                'requested_time' => $this->requested_time,
                'accepted_time' => $this->accepted_time,
            ]);

            $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'requested_by', $this->requested_by])
                ->andFilterWhere(['like', 'accepted_by', $this->accepted_by]);

            return $dataProvider;
        }else{

            $query = MoneyTransfer::find();
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
                'trn_dt' => $this->trn_dt,
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
                'account_id' => $this->account_id,
                'status' => $this->status,
                'amount' => $this->amount,
                'requested_time' => $this->requested_time,
                'accepted_time' => $this->accepted_time,
            ]);

            $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'requested_by', $this->requested_by])
                ->andFilterWhere(['like', 'accepted_by', $this->accepted_by]);

            return $dataProvider;
        }
    }
}
