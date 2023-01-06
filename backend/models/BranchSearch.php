<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Branch;

/**
 * BranchSearch represents the model behind the search form of `backend\models\Branch`.
 */
class BranchSearch extends Branch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id','branch_manager'], 'integer'],
            [['name', 'created_by', 'created_at','location','initial_balance'], 'safe'],
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
        if(\Yii::$app->User->can('BusinessOwner')) {
            $query = Branch::find();
            $query->where(['in', 'company_id', User::myCompanyID()]);

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
                'company_id' => $this->company_id,
                'branch_manager' => $this->branch_manager,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'initial_balance', $this->initial_balance])
                ->andFilterWhere(['like', 'location', $this->location]);

            return $dataProvider;
        }elseif (\Yii::$app->User->can('BranchManager')){
            $query = Branch::find();
           // $query->where(['in', 'company_id', User::myCompanyID()]);
            $query->where(['branch_manager' => \Yii::$app->user->identity->id]);

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
                'company_id' => $this->company_id,
                'branch_manager' => $this->branch_manager,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'initial_balance', $this->initial_balance])
                ->andFilterWhere(['like', 'location', $this->location]);

            return $dataProvider;
        }
        elseif (\Yii::$app->User->can('admin')){
            $query = Branch::find();
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
                'company_id' => $this->company_id,
                'branch_manager' => $this->branch_manager,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'initial_balance', $this->initial_balance])
                ->andFilterWhere(['like', 'location', $this->location]);

            return $dataProvider;
        }
    }
}
