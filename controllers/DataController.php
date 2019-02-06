<?php
/**
 * Created by PhpStorm.
 * User: shaklin
 * Date: 22.08.18
 * Time: 17:49
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class DataController extends Controller
{
    public function actionGetData()
    {

        $result = $this->suggest("address", array("query"=>"москва серпуховская", "count"=>2));
        var_dump($result);

        print_r('df');
        die();
    }

    public function suggest($type, $fields)
    {
        $result = false;
        if ($ch = curl_init("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/$type"))
        {
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token e0b13d20f525151958c8b36c08b594e38250e1ed'
            ));
            curl_setopt($ch, CURLOPT_POST, 1);
            // json_encode
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            curl_close($ch);
        }
        return $result;
    }

    protected function loggingData($logData){
        $csv_filename = "get_data"."_".date("Y-m-d_H-i",time()).".csv";
        $fd = fopen ($csv_filename, "w");
        fputs($fd, $logData);
        fclose($fd);
    }
}