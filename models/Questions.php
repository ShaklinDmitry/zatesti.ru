<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;


class Questions extends ActiveRecord
{

    public function rules()
    {
        return [
            [['text', 'user_id', 'choice0','choice1','choice2','choice3','correct_choice'], 'safe'],
        ];
    }

     public static function tableName()
     {
         return 'questions';
     }

     public function getAnswers($id){
        $questions = Questions::findOne(['id' => $id]);

        return $questions;
     }

     public function search(){
        $query = Questions::find();

         $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'forcePageParam' => false,
                 'pageSizeParam' => false,
                 'pageSize' => 5
             ]
         ]);

        return $dataProvider;
     }
}