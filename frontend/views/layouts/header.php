<?php

use common\widgets\Authorization;
use common\widgets\Navigation;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<header class="header">
    <div class="container">
        <div class="content">
            <a href="<?= Url::home() ?>" class="link home">homeLink</a>
            <div class="burger-content">
                <nav class="navigation">
                    <ul>
                        <?= Navigation::widget() ?>
                    </ul>
                </nav>
                <?= Html::beginForm(['/article/search'], 'post', ['class' => 'search'])
                . Html::input('text', 'q', null, ['class' => 'input', 'placeholder' => 'search'])
                . Html::submitButton('', ['class' => 'button'])
                . Html::endForm()
            ?>
                <?= Authorization::widget() ?>
            </div>
            <div class="burger">
                <span class="line top"></span>
                <span class="line middle"></span>
                <span class="line bottom"></span>
            </div>
        </div>
    </div>
</header>