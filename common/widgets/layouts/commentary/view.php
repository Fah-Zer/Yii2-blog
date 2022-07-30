<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;

?>

<div class="commentaries-content">
    <?php foreach ($this->commentaries as $commentary) : ?>
        <div class="comment">
            <div class="top">
                <?= Html::img('@web/img/user/' . $commentary['image'], ['class' => 'img']) ?>
                <span class="nickname"><?= '@' . $commentary['username'] ?></span>
                <span class="date"><?= $formatter->asDate($commentary['created_at']) ?></span>
            </div>
            <div class="middle">
                <p class="text"><?= $commentary['text'] ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>