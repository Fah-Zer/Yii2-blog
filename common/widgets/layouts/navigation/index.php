<?php

use yii\helpers\Url;

?>
<li class="spoiler-dropdown">
    <div class="header">
        <a href="<?= Url::to(['category', 'id' => $nav['id']]) ?>" class="link item"><?= $nav['name'] ?></a>
        <?php if (isset($nav['children'])) : ?>
            <div class="plus">
                <span class="line horizontal"></span>
                <span class="line vertical"></span>
            </div>
        <?php endif ?>
    </div>
    <?php if (isset($nav['children'])) : ?>
        <ul class="body">
            <?php foreach ($nav['children'] as $child) : ?>
                <li><a href="<?= Url::to(['category', 'id' => $child['id']]) ?>" class="link item"><?= $child['name'] ?></a></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</li>