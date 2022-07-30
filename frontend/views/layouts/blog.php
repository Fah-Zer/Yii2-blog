<?php

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!doctype html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

</head>

<body class="wrapper">

    <?php $this->beginBody() ?>

    <?= $this->render('header') ?>

    <main class="main">
        <div class="container">
            <div class="content">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </main>

    <?php $this->endBody() ?>

</body>

</html>

<?php $this->endPage() ?>