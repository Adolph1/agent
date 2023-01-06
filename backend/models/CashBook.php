<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cash_book".
 *
 * @property int $id
 * @property int $branch_id
 * @property int $product_id
 * @property string $product_code
 * @property string $trn_dt
 * @property int $money_in_account
 * @property int $money_out_account
 * @property int $transaction_account_id
 * @property float $in_amount
 * @property float $out_amount
 * @property float $transaction_amount
 * @property string|null $description
 * @property string $period
 * @property string $year
 * @property string $maker
 * @property string $maker_time
 * @property int $trn_stat
 *
 * @property Branch $branch
 */
class CashBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cash_book';
    }

    public static function getTodayWithdrawByAccountID($id)
    {
        $sum = CashBook::find()->where(['money_out_account' => $id,'trn_dt' => date('Y-m-d')])->sum('out_amount');
        if($sum != null){
            return $sum;
        }else{
            return 0.00;
        }
    }

    public static function getTodayDepositByAccountID($id)
    {
        $sum = CashBook::find()->where(['money_in_account' => $id,'trn_dt' => date('Y-m-d')])->sum('in_amount');
        if($sum != null){
            return $sum;
        }else{
            return 0.00;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'product_id', 'transaction_account_id','transaction_amount', 'trn_dt'], 'required'],
            [['branch_id', 'product_id', 'money_in_account', 'money_out_account', 'trn_stat','transaction_account_id'], 'integer'],
            [['trn_dt', 'maker_time'], 'safe'],
            [['in_amount', 'out_amount','transaction_amount'], 'number'],
            [['product_code'], 'string', 'max' => 3],
            [['description', 'maker'], 'string', 'max' => 200],
            [['period'], 'string', 'max' => 2],
            [['year'], 'string', 'max' => 4],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'branch_id' => Yii::t('app', 'Branch'),
            'product_id' => Yii::t('app', 'Transaction Type '),
            'product_code' => Yii::t('app', 'Product Code'),
            'trn_dt' => Yii::t('app', 'Trn Dt'),
            'transaction_account_id' => Yii::t('app', 'Transaction Account'),
            'money_in_account' => Yii::t('app', 'Money In Account'),
            'money_out_account' => Yii::t('app', 'Money Out Account'),
            'in_amount' => Yii::t('app', 'In Amount'),
            'out_amount' => Yii::t('app', 'Out Amount'),
            'description' => Yii::t('app', 'Description'),
            'period' => Yii::t('app', 'Period'),
            'year' => Yii::t('app', 'Year'),
            'maker' => Yii::t('app', 'Maker'),
            'maker_time' => Yii::t('app', 'Maker Time'),
            'trn_stat' => Yii::t('app', 'Trn Stat'),
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'transaction_account_id']);
    }



}
