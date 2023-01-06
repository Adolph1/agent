<?php
namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $full_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $last_login
 * @property string $auth_key
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $branch_id
 * @property string $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Company $company
 */

class User extends \common\models\User
{
    public $password;
    public $repassword;
    private $_statusLabel;
    private $_roleLabel;

    public static function getUsername()
    {
        return Yii::$app->user->identity->username;
    }

    public static function getUserTime()
    {
        return date('Y-m-d H:i:s');
    }

    public static function getUsernameById($user_id)
    {
        $user = User::findOne(['id' => $user_id]);
        if($user != null){
            return $user->username;
        }else{
            return null;
        }
    }

    public static function getUserBranch($user_id)
    {
        $user = User::findOne(['id' => $user_id]);
        if($user != null){
            return $user->branch_id;
        }else{
            return null;
        }
    }

    public static function myCompanyID()
    {
        $user = User::findOne(['id' => Yii::$app->user->identity->id]);
        if($user != null){
            return $user->company_id;
        }else{
            return null;
        }
    }

    public static function myCompanyName()
    {
        $user = User::findOne(['id' => Yii::$app->user->identity->id]);
        if($user != null){
            return $user->company->name;
        }else{
            return null;
        }
    }

    public static function getFullName($branch_manager)
    {
        $user = User::findOne(['id' => $branch_manager]);
        if($user != null){
            return $user->full_name;
        }else{
            return null;
        }
    }


    /**
     * @inheritdoc
     */
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }


    /**
     * @inheritdoc
     */
    public static function getArrayStatus()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('app', 'STATUS_INACTIVE'),
            self::STATUS_DELETED => Yii::t('app', 'STATUS_INACTIVE'),
        ];
    }


    public static function getArrayRole()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function getArrayRoleGroups()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }


    public function getRoleLabel()
    {

        if ($this->_roleLabel === null) {
            $roles = self::getArrayRole();
            $this->_roleLabel = $roles[$this->role];
        }
        return $this->_roleLabel;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','company_id','full_name'], 'required'],
            [['password', 'repassword'], 'required', 'on' => ['createUser']],
            [['username', 'password', 'repassword'], 'trim'],
            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 30],
            // Unique
            [['username',], 'unique'],
            //[['full_name', 'branch'], 'default'],
            [['company_id','branch_id'], 'integer'],
            // Username
            //['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 30],
            // E-mail
            ['full_name', 'string', 'max' => 200],
            ['email', 'email'],
            // Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            // Status
            ['role', 'in', 'range' => array_keys(self::getArrayRole())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['username', 'password', 'repassword', 'status', 'role','full_name','company_id'],
            'createUser' => ['username', 'password', 'repassword', 'status', 'role', 'full_name','company_id'],
            'admin-update' => ['username', 'password', 'repassword', 'status', 'role','full_name','company_id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'password' => Yii::t('app', 'Password'),
                'repassword' => Yii::t('app', 'Repassword'),
                'company_id' => Yii::t('app', 'Company'),
                'branch_id' => Yii::t('app', 'Branch')
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || (!$this->isNewRecord && $this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
                $this->generatePasswordResetToken();
            }
            return true;
        }
        return false;
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
