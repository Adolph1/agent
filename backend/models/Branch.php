<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $branch_manager
 * @property string|null $created_by
 * @property string|null $initial_balance
 * @property string $location
 * @property string|null $created_at
 *
 * @property Company $company
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    public static function getMyBranchBalance()
    {
//        $mybranch = Branch::findOne(['branch_manager' => Yii::$app->user->identity->id]);
//        if($mybranch != null){
//            return $mybranch->initial_balance;
//        }else{
//            return 0.00;
//        }
        ///gets sum of balances of all branch accounts
        $accounts_sum = Account::find()->where(['branch_id' => Branch::getMyBranchId()])->sum('initial_balance');
        if($accounts_sum != null){
            return $accounts_sum;
        }else{
            return 0.00;
        }


    }

    public static function myBranchName()
    {
        $mybranch = Branch::findOne(['branch_manager' => Yii::$app->user->identity->id]);
        if($mybranch != null){
            return $mybranch->name;
        }else{
            return null;
        }
    }

    public static function getMyBranches()
    {
        return ArrayHelper::map(Branch::find()->where(['company_id' => User::myCompanyID()])->all(),'id','name');
    }

    public static function getMyBranchId()
    {
        $mybranch = Branch::findOne(['branch_manager' => Yii::$app->user->identity->id]);
        if($mybranch != null){
            return $mybranch->id;
        }else{
            return null;
        }
    }

    public static function getMyBranch()
    {
        return ArrayHelper::map(Branch::find()->where(['branch_manager' => Yii::$app->user->identity->id])->all(),'id','name');
    }

    public static function getCompanyBranches()
    {
        return ArrayHelper::map(Branch::find()->where(['!=','branch_manager',Yii::$app->user->identity->id])->andWhere(['company_id' => User::myCompanyID()])->all(),'id','name');
    }

    public static function getOwnerBranchIds()
    {
        if(Yii::$app->user->can('BusinessOwner')){
            $branchesIds = Branch::find()->select('id')->where(['company_id' => User::myCompanyID()]);
            if($branchesIds != null){
                return $branchesIds;
            }else{
                return null;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company_id','location'], 'required'],
            [['company_id','branch_manager'], 'integer'],
            [['initial_balance'], 'number'],
            [['created_at'], 'safe'],
            [['name', 'created_by','location'], 'string', 'max' => 200],
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
            'company_id' => Yii::t('app', 'Company'),
            'branch_manager' => Yii::t('app', 'Branch Manager'),
            'initial_balance' => Yii::t('app', 'Opening Balance'),
            'location' => Yii::t('app', 'Location'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
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
