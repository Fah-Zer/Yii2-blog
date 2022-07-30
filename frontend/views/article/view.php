<?php

use common\widgets\Commentary;
use common\widgets\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;

?>

<div class="article">
    <?= Html::img('@web/img/article/' . $article['image'], ['class' => 'img']) ?>
    <h1 class="main-title"><?= $article['title'] ?></h1>
    <div class="inline">
        <div class="left">
            <?= Html::img('@web/img/user/' . $article['user_image'], ['class' => 'img']) ?>
            <div class="info">
                <span class="item"><?= '@' . $article['username'] ?></span>
                <span class="item"><?= $article['category_name'] ?></span>
            </div>
            <?php if ($article['user_id'] === Yii::$app->user->id) : ?>
                <div class="functions">
                    <a class="item" href="<?= Url::to(['update', 'id' => $article['id']]) ?>">edit</a>
                    <a class="item" href="<?= Url::to(['delete', 'id' => $article['id']]) ?>">delete</a>
                </div>
            <?php endif ?>
        </div>
        <div class="right">
            <span class="item">Created at: <span class="date"><?= $formatter->asDate($article['created_at']) ?></span></span>
            <span class="item">Updated at: <span class="date"><?= $formatter->asDate($article['updated_at']) ?></span></span>
        </div>
    </div>
    <p class="text"><?= $article['description'] ?></p>
</div>
<?= Commentary::widget([
    'commentaries' => $commentaries,
    'article_id' => $article['id'],
]) ?>
<ul class="paginator">
    <?= Pagination::widget([
        'pagination' => $pages,
    ]) ?>
</ul>