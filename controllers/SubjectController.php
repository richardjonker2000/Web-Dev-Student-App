<?php

namespace app\controllers;

use app\models\Search\SubjectSearch;
use app\models\Student;
use app\models\StudentSubject;
use app\models\Subject;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class SubjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'list-subscribed'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['list-subscribed', 'subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['student'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subject model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subject();
        $programs = Program::getAllAsArray();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'programs' => $programs
        ]);
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $programs = Program::getAllAsArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'programs' => $programs
        ]);
    }

    /**
     * Deletes an existing Subject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Lists all Subject models.
     * @return mixed
     */
    public function actionList()
    {
        $model = new Subject();
        $searchModel = new SubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->_subscribeUnsubscribe();

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Lists all Subject models.
     * @return mixed
     */
    public function actionListSubscribed()
    {
        $searchModel = new SubjectSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->searchSubscribed(Yii::$app->request->queryParams);

        $this->_subscribeUnsubscribe();

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function _subscribeUnsubscribe(){
        if (Yii::$app->request->isPost) {
            $subject_id = Yii::$app->request->post('id');
            $subject = Subject::findOne($subject_id);
            if($subject) {
                $user_id = Yii::$app->user->id;
                $action = Yii::$app->request->post('action');
                if($action == 'subscribe') {
                    if ($subject->subscribe($user_id)) {
                        Yii::$app->session->addFlash("success", "Subject `{$subject->name}` subscribed");
                    } else {
                        Yii::$app->session->addFlash("danger", "Error subscribing Subject `{$subject->name}`");
                    }
                }else if($action == 'unsubscribe') {
                    if ($subject->unsubscribe($user_id)) {
                        Yii::$app->session->addFlash("success", "Subject `{$subject->name}` unsubscribed");
                    } else {
                        Yii::$app->session->addFlash("danger", "Error subscribing Subject `{$subject->name}`");
                    }
                }else{
                    Yii::$app->session->addFlash("danger", "Invalid option");
                }
            }else{
                Yii::$app->session->addFlash("danger", "Subject unavailable");
            }
        }
    }
}
