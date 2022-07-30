<?php

namespace common\models;

use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    public $id;
    public $name;

    public static function tableName()
    {
        return '{{%role}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'name' => \Yii::t('app', 'Your name'),
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }
}
