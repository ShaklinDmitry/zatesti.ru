<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
$this->title = '';
?>

<h1><?= Html::encode($this->title) ?></h1>
sd
<?php Pjax::begin(['id' => 'new_note']);
?>

    <div style="display: none;" id="currentPage" value=<?php echo $curPage;?>></div>

    <?php $form = ActiveForm::begin([ 
        'id' => 'my-form-id',
        'action' => 'game-screen',
        'enableAjaxValidation' => true,
        'validationUrl' => 'validate',
        'options' => ['data-pjax' => true]
    ]); ?>
        <?= $form->field($model, 'text') ?>
        <?= Html::submitButton('Save') ?>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php
    $js = <<<JS
    
    $( document ).ready(function() {
            $("#new_note").on("pjax:end", function() { 
                $.pjax.reload({container:"#notes", url:"game-screen?page=" + $('#currentPage').attr('value')});  //Reload GridView  
            });   
       });
    
    
   /* $('form').on('beforeSubmit',function() {
        var data = $(this).serialize();
         $.ajax({
            url: '/zatesti/web/index.php/game-screen/test',
            type: 'POST',
            data: data,
            success: function(res){
                alert(res); 
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    })*/
    
JS;
$this->registerJs($js);
?>

<?php Pjax::begin(['id' => 'notes']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'caption' => 'lol',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'text',
        'user_id',

        ['class' => 'yii\grid\ActionColumn',
         'template' => '{view}{delete}{update}',
         'buttons' => [
             'update' => function ($url, $model, $key) {
                 return Html::a('Update', $url);
             },
         ],
        ],
    ],

]);?>
<?php Pjax::end(); ?>

<?php
Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'id' => 'modal',
    'size' => 'modal-lg',
    'toggleButton' => ['label' => 'click me'],
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>


