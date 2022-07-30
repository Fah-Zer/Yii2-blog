<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

class Authorization extends Widget
{
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            include __DIR__ . '/layouts/authorization/signin.php';
        } else {
            include __DIR__ . '/layouts/authorization/signout.php';
        }        
    }
}

?>