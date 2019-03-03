<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\base\Widget;
use app\widgets\AnswerItem;
?>



<?= AnswerItem::widget(['id' => 1, 'answer' => 'Answer1', 'class' => 'answer']) ?>
<?= AnswerItem::widget(['id' => 2, 'answer' => 'Answer2', 'class' => 'answer']) ?>
<?= AnswerItem::widget(['id' => 3, 'answer' => 'Answer3', 'class' => 'answer']) ?>
<?= AnswerItem::widget(['id' => 4, 'answer' => 'Answer4', 'class' => 'answer']) ?>



