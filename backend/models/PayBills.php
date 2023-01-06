<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pay_bills".
 *
 * @property int $id
 * @property int $company_id
 * @property int $branch_id
 * @property int $account_id
 * @property float $amount
 * @property int $service_type_id
 * @property string $trn_dt
 * @property string|null $reference_no
 * @property int|null $status
 * @property string|null $created_by
 * @property string|null $created_at
 *
 * @property Branch $branch
 * @property Account $account
 */
class PayBills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_bills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'branch_id', 'account_id', 'amount', 'service_type_id', 'trn_dt'], 'required'],
            [['company_id', 'branch_id', 'account_id', 'service_type_id', 'status'], 'integer'],
            [['amount'], 'number'],
            [['trn_dt', 'created_at'], 'safe'],
            [['reference_no', 'created_by'], 'string', 'max' => 200],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'amount' => Yii::t('app', 'Amount'),
            'service_type_id' => Yii::t('app', 'Service Type ID'),
            'trn_dt' => Yii::t('app', 'Trn Dt'),
            'reference_no' => Yii::t('app', 'Reference No'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
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
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }
}
