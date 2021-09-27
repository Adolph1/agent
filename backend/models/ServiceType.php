<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "service_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property Subscriber[] $subscribers
 */
class ServiceType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_type';
    }

    public static function getAll()
    {
        return ArrayHelper::map(ServiceType::find()->all(),'id','title');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[Subscribers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(Subscriber::className(), ['service_type_id' => 'id']);
    }
}
