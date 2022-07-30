<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="flex-center">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form',
        ],
        'fieldConfig' => [
            'template' => '<div class=input-wrapper>{label}{input}{hint}{error}</div>',
            'labelOptions' => [
                'class' => 'label',
            ],
            'inputOptions' => [
                'class' => 'input',
            ],
            'errorOptions' => [
                'class' => 'error',
            ],
        ]
    ]) ?>

    <h1 class="main-title"><?= $title ?></h1>

    <?= $form->field($model, 'imageFile', [
        'template' => '<div class=input-wrapper><label class=label for=' . $name . '>
        Choose your image</label>{label}{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'input',
        ],
        'inputOptions' => [
            'class' => 'hidden',
        ],
    ])->fileInput() ?>

    <?= Html::submitButton('Send', ['class' => 'button', 'name' => 'signin-button']) ?>

    <?php ActiveForm::end(); ?>

</div>