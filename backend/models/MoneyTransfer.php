<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "money_transfer".
 *
 * @property int $id
 * @property string $trn_dt
 * @property int $from_branch_id
 * @property int $to_branch_id
 * @property float $amount
 * @property int $account_id
 * @property int $status
 * @property string|null $description
 * @property string|null $requested_by
 * @property string|null $requested_time
 * @property string|null $accepted_by
 * @property string|null $accepted_time
 *
 * @property Account $account
 * @property Branch $fromBranch
 * @property Branch $toBranch
 */
class MoneyTransfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_transfer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trn_dt', 'from_branch_id', 'to_branch_id', 'amount', 'account_id'], 'required'],
            [['trn_dt', 'requested_time', 'accepted_time'], 'safe'],
            [['from_branch_id', 'to_branch_id', 'account_id','status'], 'integer'],
            [['amount'], 'number'],
            [['description', 'requested_by', 'accepted_by'], 'string', 'max' => 200],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['from_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['from_branch_id' => 'id']],
            [['to_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['to_branch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trn_dt' => Yii::t('app', 'Date'),
            'from_branch_id' => Yii::t('app', 'From'),
            'to_branch_id' => Yii::t('app', 'To'),
            'amount' => Yii::t('app', 'Amount'),
            'account_id' => Yii::t('app', 'Account'),
            'description' => Yii::t('app', 'Description'),
            'requested_by' => Yii::t('app', 'Created By'),
            'requested_time' => Yii::t('app', 'Created Time'),
            'accepted_by' => Yii::t('app', 'Accepted By'),
            'accepted_time' => Yii::t('app', 'Accepted Time'),
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * Gets query for [[FromBranch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'from_branch_id']);
    }

    /**
     * Gets query for [[ToBranch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'to_branch_id']);
    }
}
