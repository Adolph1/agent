<?php

namespace backend\models;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $name
 * @property string $account_no
 * @property string $agent_no
 * @property int $service_provider_id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $is_cash_account
 * @property float|null $initial_balance
 * @property string|null $maker
 * @property string|null $maker_time
 *
 * @property Branch $branch
 * @property Company $company
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    public static function getAccount()
    {
        $model = Account::find()->orderBy(['id' => SORT_DESC])->one();
        if($model != null){
            return 'MMS'.sprintf("%04d", ($model->id + 1));
        }else{
            return 'MMS0001';
        }

    }

    public static function getMyAccount()
    {
        return ArrayHelper::map(Account::find()->where(['branch_id' => Branch::getMyBranchId(), 'is_cash_account' => 0])->all(),'id','name');
    }

    public static function getMyCashAccount()
    {
        $account = Account::findOne(['is_cash_account' => 1, 'branch_id' => Branch::getMyBranchId()]);
        if($account != null){
            return $account->id;
        }else{
            return null;
        }
    }

    public static function UpdateBalances($money_in_account, $in_amount, $money_out_account, $out_amount)
    {
        $flag = 0;
        $inBalance = (float)Account::getAccountBalance($money_in_account);
        $outBalance = (float)Account::getAccountBalance($money_out_account);

        if($outBalance >= $out_amount){

            Account::updateAll(['initial_balance' => $outBalance-(float)$out_amount],['id' => $money_out_account]);
            Account::updateAll(['initial_balance' => $inBalance+(float)$in_amount],['id' => $money_in_account]);
           $flag = 1;
//           var_dump($money_in_account);
//           var_dump((float)$inBalance);
//            var_dump($in_amount);
//            exit();
            return $flag;
        }else{

            return $flag;
        }
    }

    private static function getAccountBalance($id)
    {
        $account = Account::findOne($id);
        if($account != null){
            return $account->initial_balance;
        }
    }

    public static function getAll()
    {
        return ArrayHelper::map(Account::find()->where(['company_id' => User::myCompanyID()])->all(),'id',function($model){
            return $model->name .' ('. $model->branch->name. ')';
        });
    }

    public static function UpdateMoneyOut($account_id, $money_out)
    {

        $balance= Account::getAccountBalance($account_id);
        if($balance >= $money_out){
        Account::updateAll(['initial_balance' => $balance - $money_out],['id' => $account_id]);
            return 1;

        }else{
            return 0;
        }
    }

    public static function UpdateMoneyIn($account_id, $money_in)
    {
        $balance= Account::getAccountBalance($account_id);

            Account::updateAll(['initial_balance' => $balance + $money_in],['id' => $account_id]);
            return 1;

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'agent_no', 'service_provider_id','branch_id'], 'required'],
            [['service_provider_id', 'company_id', 'branch_id','is_cash_account'], 'integer'],
            [['initial_balance'], 'number'],
            [['maker_time'], 'safe'],
            [['name', 'account_no', 'agent_no', 'maker'], 'string', 'max' => 200],
            [['account_no'], 'unique'],
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
            'name' => Yii::t('app', 'Name'),
            'account_no' => Yii::t('app', 'Account No'),
            'agent_no' => Yii::t('app', 'Agent No'),
            'service_provider_id' => Yii::t('app', 'Account Provider'),
            'company_id' => Yii::t('app', 'Company'),
            'branch_id' => Yii::t('app', 'Branch'),
            'initial_balance' => Yii::t('app', 'Initial Balance'),
            'is_cash_account' => Yii::t('app','Cash Account'),
            'maker' => Yii::t('app', 'Maker'),
            'maker_time' => Yii::t('app', 'Maker Time'),
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
     * Gets query for [[ServiceProvider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(ServiceProvider::className(), ['id' => 'service_provider_id']);
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
