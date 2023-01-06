<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AccountFloat;

/**
 * AccountFloatSearch represents the model behind the search form of `backend\models\AccountFloat`.
 */
class AccountFloatSearch extends AccountFloat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'branch_id', 'company_id', 'status'], 'integer'],
            [['trn_dt', 'maker', 'maker_time'], 'safe'],
            [['float_amount'], 'number'],
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
            $query = AccountFloat::find();
            $query->where(['in','branch_id',Branch::getMyBranchId()]);


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
                'account_id' => $this->account_id,
                'branch_id' => $this->branch_id,
                'company_id' => $this->company_id,
                'float_amount' => $this->float_amount,
                'status' => $this->status,
                'maker_time' => $this->maker_time,
            ]);

            $query->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }elseif (\Yii::$app->user->can('BusinessOwner')){
            $query = AccountFloat::find();
            $query->where(['in','branch_id',Branch::getOwnerBranchIds()]);


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
                'account_id' => $this->account_id,
                'branch_id' => $this->branch_id,
                'company_id' => $this->company_id,
                'float_amount' => $this->float_amount,
                'status' => $this->status,
                'maker_time' => $this->maker_time,
            ]);

            $query->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }else{
            $query = AccountFloat::find();


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
                'account_id' => $this->account_id,
                'branch_id' => $this->branch_id,
                'company_id' => $this->company_id,
                'float_amount' => $this->float_amount,
                'status' => $this->status,
                'maker_time' => $this->maker_time,
            ]);

            $query->andFilterWhere(['like', 'maker', $this->maker]);

            return $dataProvider;
        }
    }
}
