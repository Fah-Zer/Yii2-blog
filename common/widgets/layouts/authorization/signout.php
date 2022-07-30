<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="spoiler-dropdown">
    <div class="header">
        <span class="link"><?= '@' . Yii::$app->user->identity->username ?></span>
        <div class="plus">
            <span class="line horizontal"></span>
            <span class="line vertical"></span>
        </div>
    </div>
    <ul class="body">
        <li><a href="<?= Url::to(['user/update', 'id' => Yii::$app->user->id]) ?>" class="link item">Acount</a></li>
        <li><a href="<?= Url::to(['article/create']) ?>" class="link item">New article</a></li>
        <li>
            <?= Html::beginForm(['/user/signout'], 'post')
                . Html::submitButton('Sign out', ['class' => 'link item'])
                . Html::endForm()
            ?>
        </li>
    </ul>
</div>