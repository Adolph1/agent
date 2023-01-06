<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "account_float".
 *
 * @property int $id
 * @property string $trn_dt
 * @property int $account_id
 * @property int $branch_id
 * @property int $company_id
 * @property float $float_amount
 * @property int|null $status
 * @property string|null $maker
 * @property string|null $maker_time
 *
 * @property Account $account
 * @property Branch $branch
 * @property Company $company
 */
class AccountFloat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account_float';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trn_dt', 'account_id', 'branch_id', 'company_id', 'float_amount'], 'required'],
            [['trn_dt', 'maker_time'], 'safe'],
            [['account_id', 'branch_id', 'company_id', 'status'], 'integer'],
            [['float_amount'], 'number'],
            [['maker'], 'string', 'max' => 200],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trn_dt' => Yii::t('app', 'Trn Dt'),
            'account_id' => Yii::t('app', 'Account'),
            'branch_id' => Yii::t('app', 'Branch'),
            'company_id' => Yii::t('app', 'Company'),
            'float_amount' => Yii::t('app', 'Float Amount'),
            'status' => Yii::t('app', 'Status'),
            'maker' => Yii::t('app', 'Maker'),
            'maker_time' => Yii::t('app', 'Maker Time'),
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
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
