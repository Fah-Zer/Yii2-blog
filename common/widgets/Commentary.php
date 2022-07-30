<?php

namespace common\widgets;

use common\models\User;
use Yii;
use yii\base\Widget;

class Commentary extends Widget
{
    public $commentaries;
    public $article_id;

    public function run()
    {
        if (count($this->commentaries) > 0) {
            $titleContent = 'Commentaries';
        } else {
            $titleContent = 'No commentaries';
        }
        $title = "<h1 class=title>" . $titleContent . "</h1>";
        echo "<div class=commentaries>";
        echo $title;
        if (!Yii::$app->user->isGuest) {
            $sender = User::find()->where('id = :id', [':id' => Yii::$app->user->id])->asArray()->one();
            $article_id = $this->article_id;
            include __DIR__ . '/layouts/commentary/index.php';
        } else {
            include __DIR__ . '/layouts/commentary/guest.php';
        }
        if (count($this->commentaries) > 0) {
            include __DIR__ . '/layouts/commentary/view.php';
        }
        echo "</div>";
    }
}
