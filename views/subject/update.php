<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */
/* @var $programs array */

$this->title = 'Update Subject: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subject-update">

    <?= $this->render('_form', [
        'model' => $model,
        'programs' => $programs
    ]) ?>

</div>
