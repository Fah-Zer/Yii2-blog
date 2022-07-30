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

    <h1 class="main-title">Sign Up</h1>

    <?= $form->field($model, 'email')->input('email', ['placeholder' => 'Type your email']) ?>

    <?= $form->field($model, 'imageFile', [
        'template' => '<div class=input-wrapper><label class=label for=' . $name . ' -imagefile>
        Choose your image</label>{label}{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'input',
        ],
        'inputOptions' => [
            'class' => 'hidden',
        ],
    ])->fileInput() ?>

    <?= $form->field($model, 'username')->input('text', ['placeholder' => 'Type your nickname']) ?>

    <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => 'Type your password']) ?>

    <p class="info">
        Already have an account? -
        <a class="link" href="<?= Url::to('signin') ?>">Sign in</a>
    </p>

    <?= Html::submitButton('Send', ['class' => 'button', 'name' => 'signin-button']) ?>

    <?php ActiveForm::end(); ?>

</div>