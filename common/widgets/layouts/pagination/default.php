<?php
use yii\helpers\Url;
?>

<li><a href="<?= Url::to([$this->currentRoute, 'id' => $this->id, 'page' => $link])?>"
class='item'><?= $link ?></a></li>
