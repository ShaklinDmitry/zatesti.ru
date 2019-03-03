<?php
/**
 * Created by PhpStorm.
 * User: shakl
 * Date: 03.03.2019
 * Time: 13:42
 */

namespace app\controllers;

use app\models\PlayScreen;
use app\models\Questions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class PlayScreenController extends Controller
{
    public $questions;

    public function actionIndex(){
        return $this->render('playScreen');
    }

    public function actionGetQuestion(){

    }

    public function actionGetAnswers($id){
        $questions = new Questions();

        $questionsList = $questions->getAnswers($id);
    }
}