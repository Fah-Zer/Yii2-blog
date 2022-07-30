<?php

namespace common\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    public $imageFile;
    public $oldImage;

    public static function tableName()
    {
        return '{{%article}}';
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
            [['user_id', 'category_id', 'title', 'description'], 'required'],
            [['user_id', 'category_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'user_id' => \Yii::t('app', 'Author Id'),
            'category_id' => \Yii::t('app', 'Category Id'),
            'title' => \Yii::t('app', 'Title'),
            'description' => \Yii::t('app', 'Description'),
            'image' => \Yii::t('app', 'Image name'),
            'created_at' => \Yii::t('app', 'Created at'),
            'updated_at' => \Yii::t('app', 'Updated at'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeValidate()
    {
        $this->user_id = Yii::$app->user->id;
        if ($this->imageFile !== null) {
            $this->image = $this->upload();
        }
        return parent::beforeValidate();
    }

    public function updateArticle($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $article = $this->find()->where('id = :id', [':id' => $id])->one();
        $this->oldImage = $article->image;
        $article->category_id = $this->category_id;
        $article->title = $this->title;
        $article->description = $this->description;
        if ($this->imageFile !== null) {
            $article->image = $this->image;
            unlink('img/article/' . $this->oldImage);
        } else {
            $article->image = $this->oldImage;
        }

        return $article->save();
    }

    public function deleteArticle()
    {
        $imageName = $this->image;
        $this->delete();
        unlink('img/article/' . $this->image);
    }

    public function upload()
    {
        $uniqueImageName = time() . '_' . $this->imageFile->baseName;
        $fullImageName = $uniqueImageName . '.' . $this->imageFile->extension;
        $this->imageFile->saveAs('img/article/' . $fullImageName);
        return $fullImageName;
    }
}
