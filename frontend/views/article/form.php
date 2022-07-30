<?php

use common\models\Category;
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

    <?= $form->field($model, 'title')->input('text', ['placeholder' => 'Type article title']) ?>

    <?= $form->field($model, 'imageFile', [
        'template' => '<div class=input-wrapper><label class=label for=' . $name . '-imagefile>
        Choose your image</label>{label}{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'input',
        ],
        'inputOptions' => [
            'class' => 'hidden',
        ],
    ])->fileInput() ?>

    <?= $form->field($model, 'category_id')->dropdownList(
        Category::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Выберите категорию']
    ) ?>

    <?= $form->field($model, 'description')->input('text', ['placeholder' => 'Type article description']) ?>

    <?= Html::submitButton('Send', ['class' => 'button', 'name' => 'form-button']) ?>

    <?php ActiveForm::end(); ?>

</div>