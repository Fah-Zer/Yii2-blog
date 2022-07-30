<?php

namespace frontend\controllers;

use common\models\Commentary;
use yii\web\Controller;

class CommentaryController extends Controller
{
    public function actionSend()
    {
        $model = new Commentary();
        $model->sender_id = $_POST['sender_id'];
        $model->article_id = $_POST['article_id'];
        $model->text = $_POST['text'];
        $model->save();

        $this->redirect(['article/view', 'id' => $_POST['article_id']]);
    }
}
