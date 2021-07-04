<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use wpler\modules\UserManagement\components\GhostNav;
use wpler\modules\UserManagement\UserManagementModule;
use yii\bootstrap4\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <?php

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-sm navbar-light bg-light my-nav',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Subjects', 'url' => '#', 'visible' => Yii::$app->user->can('student') , 'items' => [
                ['label' => 'All Subjects', 'url' => ['/subject/list']],
                ['label' => 'Show subjects', 'url' => ['/subject/list-subscribed']],
            ]],
            ['label' => 'Subjects', 'url' => ['/subject/list'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'FAQ', 'url' => ['/site/faq']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Admin', 'url' => '#',
                    'visible' => Yii::$app->user->can('admin'),
                    'items' => [
                        ['label' => 'Manage Users', 'url' => ['/user/admin']],
                        ['label' => 'Manage Students', 'url' => ['/student/index']],
                        ['label' => 'Manage Programs', 'url' => ['/program/index']],
                        ['label' => 'Manage Subjects', 'url' => ['/subject/index']],
                ]],
            ['label' => 'Login', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest ],
            ['label' => 'Users', 'url' => '#', 'visible' => !Yii::$app->user->isGuest ,
                'items' => [
                    ['label' => 'Enroll Student', 'url' => ['/student/enroll'], 'visible' => !Yii::$app->user->isGuest && !Yii::$app->user->can('admin')],
                    ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ],

            ]
        ],
    ]);
    NavBar::end();
    ?>
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'my-bread']
    ]) ?>

    <div class="container">
        <div class="row">
            <div class="col-md-3 colleft">

                <p>
                    Welcome, User
                </p>
                <i class="fas fa-edit fa-8x mt-5"></i>
            </div>
            <div class="col-md-9 main">
                <div class="container">
                    <div class="row topcontent">
                        <div class="col">
                            <h1><?= $this->title ?></h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col content">
                            <?php
                            $errors = Yii::$app->session->getAllFlashes();
                            foreach ($errors as $type => $msgs) {
                                if(is_array($msgs)) {
                                    foreach ($msgs as $msg) {
                                        echo Alert::widget([
                                            'options' => ['class' => 'alert-' . $type],
                                            'body' => $msg,
                                        ]);
                                    }
                                }
                            }
                            ?>
                        <?= $content ?>
                        </div>
                    </div>
                    <div class="row footer">
                        <div class="col align-self-lg-center">
                            Copyright © 2020.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
