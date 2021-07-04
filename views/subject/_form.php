<?php

use app\models\Program;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $programs array */
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'semester')->textInput() ?>

    <?php
    echo $form->field($model, "program_id")
        ->dropDownList(
            $programs, ['prompt' => Yii::t('app', '-- Select Program --')]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
