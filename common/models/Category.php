<?php

namespace common\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function rules()
    {
        return [
            [['parent_id', 'name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'parent_id' => \Yii::t('app', 'Parent category Id'),
            'name' => \Yii::t('app', 'Category name'),
        ];
    }

    public function getArticle()
    {
        return $this->hasMany(Article::class, ['category_id' => 'id']);
    }
}
