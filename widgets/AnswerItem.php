<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AnswerItem extends Widget
{
    public $answer;
    public $id;

    public function init()
    {
        parent::init();
        if ($this->answer === null) {
            $this->answer = '';
        }
    }

    public function run()
    {
        return Html::tag('div', Html::encode($this->answer), ['id' => $this->id]);
    }
}