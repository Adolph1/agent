<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property string $full_name
 * @property string $date_of_birth
 * @property int $service_type_id
 * @property string $mobile_number
 * @property string $email_address
 * @property string $agent_code
 * @property string|null $maker
 * @property string|null $maker_time
 * @property int|null $status
 *
 * @property ServiceType $serviceType
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'date_of_birth', 'service_type_id', 'mobile_number', 'email_address', 'agent_code'], 'required'],
            [['date_of_birth', 'maker_time'], 'safe'],
            [['service_type_id', 'status'], 'integer'],
            [['full_name', 'email_address', 'agent_code', 'maker'], 'string', 'max' => 200],
            [['mobile_number'], 'string', 'max' => 13],
            [['agent_code'], 'unique'],
            [['service_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceType::className(), 'targetAttribute' => ['service_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'service_type_id' => Yii::t('app', 'Service Type ID'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'email_address' => Yii::t('app', 'Email Address'),
            'agent_code' => Yii::t('app', 'Agent Code'),
            'maker' => Yii::t('app', 'Maker'),
            'maker_time' => Yii::t('app', 'Maker Time'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[ServiceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }
}
