<?php

use yii\helpers\Html;
use yii\helpers\Url;
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

    <h1 class="main-title">Sign In</h1>

    <?= $form->field($model, 'username')->input('text', ['placeholder' => 'Type your nickname']) ?>

    <?= $form->field($model, 'password')->passwordInput()->input('Password', ['placeholder' => 'Type your nickname']) ?>

    <p class="info">
        Don't have an account? -
        <a class="link" href="<?= Url::to('signup') ?>">Sign up</a>
    </p>

    <?= Html::submitButton('Send', ['class' => 'button', 'name' => 'signin-button']) ?>

    <?php ActiveForm::end(); ?>

</div>