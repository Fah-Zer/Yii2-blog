<?php

use yii\helpers\Html;

?>

<?= Html::beginForm(['/commentary/send'], 'post', ['class' => 'comment']) ?>
<div class="top">
    <?= Html::img('@web/img/user/' . $sender['image'], ['class' => 'img']) ?>
    <span class="nickname"><?= '@' . $sender['username'] ?></span>
</div>
<div class="middle">
    <?= Html::input('hidden', 'sender_id', $sender['id']) ?>
    <?= Html::input('hidden', 'article_id', $article_id) ?>
    <?= Html::input('text', 'text', null, ['class' => 'input', 'placeholder' => 'Type your comment']) ?>
</div>
<div class="bottom">
    <?= Html::submitButton('send', ['class' => 'button send']) ?>
</div>
<?= Html::endForm() ?>