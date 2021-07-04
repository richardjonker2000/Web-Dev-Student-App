<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Program */

$this->title = 'Update Program: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
