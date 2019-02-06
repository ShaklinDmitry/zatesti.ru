<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;


class Questions extends ActiveRecord
{

    public $id;

    public function rules()
    {
        return [
            [['text', 'user_id'], 'safe'],
         //   ['text','email'],
        ];
    }

     public static function tableName()
     {
         return 'questions';
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