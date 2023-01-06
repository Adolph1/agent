<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_journal_line".
 *
 * @property int $id
 * @property string $trn_dt
 * @property int $journal_id
 * @property int $branch_id
 * @property int $account_id
 * @property float $money_in
 * @property float $money_out
 * @property string $trn_type
 * @property int|null $status
 * @property string|null $created_by
 * @property string|null $created_at
 *
 * @property Account $account
 * @property AgentJournalEntry $journal
 */
class AgentJournalLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agent_journal_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trn_dt', 'journal_id', 'branch_id', 'account_id', 'money_in', 'money_out', 'trn_type'], 'required'],
            [['trn_dt', 'created_at'], 'safe'],
            [['journal_id', 'branch_id', 'account_id', 'status'], 'integer'],
            [['money_in', 'money_out'], 'number'],
            [['trn_type'], 'string', 'max' => 1],
            [['created_by'], 'string', 'max' => 200],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['journal_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgentJournalEntry::className(), 'targetAttribute' => ['journal_id' => 'id']],
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
            'journal_id' => Yii::t('app', 'Journal ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'money_in' => Yii::t('app', 'Money In'),
            'money_out' => Yii::t('app', 'Money Out'),
            'trn_type' => Yii::t('app', 'Trn Type'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
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
     * Gets query for [[Journal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJournal()
    {
        return $this->hasOne(AgentJournalEntry::className(), ['id' => 'journal_id']);
    }
}
