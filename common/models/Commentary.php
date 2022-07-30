<?php

namespace common\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Commentary extends ActiveRecord
{
    public $id;
    public $addressee_id;

    public static function tableName()
    {
        return '{{%commentary}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['article_id', 'sender_id', 'text'], 'required'],
            [['article_id', 'sender_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'article_id' => \Yii::t('app', 'Article Id'),
            'addressee_id' => \Yii::t('app', 'Addressee Id'),
            'sender_id' => \Yii::t('app', 'Sender Id'),
            'text' => \Yii::t('app', 'Text'),
            'created_at' => \Yii::t('app', 'Created at'),
            'updated_at' => \Yii::t('app', 'Updated at'),
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    public function getAddressee()
    {
        return $this->hasOne(User::class, ['id' => 'addressee_id']);
    }

    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }
}
