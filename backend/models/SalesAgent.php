<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_agent".
 *
 * @property int $id
 * @property string $agent_name
 * @property string $agent_code
 * @property string $mobile_number
 * @property string $email_address
 * @property string|null $maker
 * @property string|null $maker_time
 * @property int|null $status
 *
 * @property Commission $commission
 */
class SalesAgent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_agent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agent_name', 'agent_code', 'mobile_number', 'email_address'], 'required'],
            [['maker_time'], 'safe'],
            [['status'], 'integer'],
            [['agent_name', 'agent_code', 'email_address', 'maker'], 'string', 'max' => 200],
            [['mobile_number'], 'string', 'max' => 13],
            [['agent_code'], 'unique'],
            ['email_address', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agent_name' => Yii::t('app', 'Agent Name'),
            'agent_code' => Yii::t('app', 'Agent Code'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'email_address' => Yii::t('app', 'Email Address'),
            'maker' => Yii::t('app', 'Maker'),
            'maker_time' => Yii::t('app', 'Maker Time'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Commission]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommission()
    {
        return $this->hasOne(Commission::className(), ['sales_agent_id' => 'id']);
    }
}
