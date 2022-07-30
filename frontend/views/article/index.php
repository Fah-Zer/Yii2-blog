<?php

use common\widgets\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;

?>

<div class="flex-column">
    <h1 class="main-title"><?= $title ?></h1>
    <div class="articles">
        <?php foreach ($articles as $article) : ?>
            <article class="article">
                <?= Html::img('@web/img/article/' . $article['image'], ['class' => 'img']) ?>
                <div class="inline">
                    <span class="item"><?= $formatter->asDate($article['created_at']) ?></span>
                    <span class="item"><?= $article['category_name'] ?></span>
                </div>
                <h2 class="title"><?= $article['title'] ?></h2>
                <p class="text"><?= $article['description'] ?></p>
                <a href="<?= Url::to(['view', 'id' => $article['id']]) ?>" class="button">read more</a>
            </article>
        <?php endforeach ?>
    </div>
    <ul class="paginator">
        <?= Pagination::widget([
            'pagination' => $pages,
        ]) ?>
    </ul>
</div>