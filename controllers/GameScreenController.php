<?php
/**
 * Created by PhpStorm.
 * User: shaklin
 * Date: 25.12.18
 * Time: 16:59
 */

namespace app\controllers;

use app\models\Questions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;

class GameScreenController extends Controller
{
    public $model;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionGameScreen(){
        $this->model = new Questions();

        if($this->model->load(Yii::$app->request->post())){
            $this->model->save();
        }

        $dataProvider = $this->model->search();

        $pagesize = $dataProvider->pagination->pageSize;
        $total = $dataProvider->totalCount;
        $curPage = (int)ceil((($total) / $pagesize));

        return $this->render('questions',
            ['model' => $this->model,
                'dataProvider' => $dataProvider,
                'curPage' => $curPage,
            ]);
    }

    public function actionDeleteItem(){
        if (Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['item_id'];

            $customer = Questions::findOne($id);
            $customer->delete();
        }
    }

    public function actionValidate(){
        $this->model = new Questions();
        $request = \Yii::$app->getRequest();

        if ($request->isPost && $this->model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($this->model);
        }
    }

    public function actionTest(){
        if(\Yii::$app->request->isAjax){
            $this->model = new Questions();

            if($this->model->load(Yii::$app->request->post())){
                $this->model->save();
            } 
            return 'Данные успешно сохранены!';
        }
    }

    public function actionUpdate(){
        $id = 0;

        $this->model = new Questions();

        if ($this->model->load(Yii::$app->request->get())) {
            $id = $this->model->id;
        }

        return $this->render('update_record',
            ['model' => $this->model]);
    }

}