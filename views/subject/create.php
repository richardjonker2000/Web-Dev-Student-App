<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */

$this->title = 'Create Subject';
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

    <?= $this->render('_form', [
        'model' => $model,
        'programs' => $programs
    ]) ?>

</div>
