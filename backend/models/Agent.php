<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "agent".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string|null $phone_number
 * @property string|null $location
 * @property string|null $created_by
 * @property string|null $created_at
 *
 * @property Company $company
 * @property AgentJournalEntry[] $agentJournalEntries
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agent';
    }

    public static function getAll()
    {
        return ArrayHelper::map(Agent::find()->where(['company_id' => User::myCompanyID()])->all(),'id','name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['name'], 'required'],
            [['created_at'], 'safe'],
            [['name', 'phone_number', 'location', 'created_by'], 'string', 'max' => 200],
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
            'company_id' => Yii::t('app', 'Company ID'),
            'name' => Yii::t('app', 'Name'),
            'phone_number' => Yii::t('app', 'Phone Number'),
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

    /**
     * Gets query for [[AgentJournalEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgentJournalEntries()
    {
        return $this->hasMany(AgentJournalEntry::className(), ['agent_id' => 'id']);
    }
}
