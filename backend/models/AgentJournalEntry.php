<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_journal_entry".
 *
 * @property int $id
 * @property string $trn_dt
 * @property int $agent_id
 * @property int $branch_id
 * @property int $company_id
 * @property string|null $description
 * @property string|null $receipt
 * @property float|null $total_money_in
 * @property float|null $total_money_out
 * @property string|null $maker_id
 * @property string|null $maker_time
 * @property string|null $auth_stat
 * @property int|null $is_reversed
 * @property string|null $checker_id
 * @property string|null $checker_time
 *
 * @property Branch $branch
 * @property Agent $agent
 * @property AgentJournalLine[] $agentJournalLines
 */
class AgentJournalEntry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agent_journal_entry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trn_dt', 'agent_id', 'branch_id', 'company_id'], 'required'],
            [['trn_dt', 'maker_time', 'checker_time'], 'safe'],
            [['total_money_in', 'total_money_out'], 'number'],
            [['agent_id', 'branch_id', 'company_id', 'is_reversed'], 'integer'],
            [['description', 'receipt', 'maker_id', 'checker_id'], 'string', 'max' => 200],
            ['total_money_in', 'compare', 'compareAttribute' => 'total_money_out'],
            [['auth_stat'], 'string', 'max' => 1],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agent::className(), 'targetAttribute' => ['agent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trn_dt' => Yii::t('app', 'Transaction Date'),
            'agent_id' => Yii::t('app', 'Agent '),
            'branch_id' => Yii::t('app', 'Branch '),
            'total_money_in' => Yii::t('app', 'Money In'),
            'total_money_out' => Yii::t('app', 'Money Out'),
            'company_id' => Yii::t('app', 'Company ID'),
            'description' => Yii::t('app', 'Description'),
            'receipt' => Yii::t('app', 'Receipt'),
            'maker_id' => Yii::t('app', 'Maker ID'),
            'maker_time' => Yii::t('app', 'Maker Time'),
            'auth_stat' => Yii::t('app', 'Auth Stat'),
            'is_reversed' => Yii::t('app', 'Is Reversed'),
            'checker_id' => Yii::t('app', 'Checker ID'),
            'checker_time' => Yii::t('app', 'Checker Time'),
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
     * Gets query for [[Agent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(Agent::className(), ['id' => 'agent_id']);
    }


    /**
     * Gets query for [[agentJournalLines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgentJournalLines()
    {
        return $this->hasMany(AgentJournalLine::className(), ['journal_id' => 'id']);
    }
}
