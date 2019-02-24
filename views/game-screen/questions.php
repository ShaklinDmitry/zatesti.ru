<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
$this->title = '';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(['id' => 'notes']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'caption' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'text',
        'choice0',
        'choice1',
        'choice2',
        'choice3',
        'correct_choice',

        ['class' => 'yii\grid\ActionColumn',
         'template' => '{delete}{update}',
         'buttons' => [
             'update' => function ($url, $model, $key) {
                 return Html::a('Редактировать', null, [
                     'title' => Yii::t('app', 'lead-update'),
                     'class'=>'updateModalButton',
                     'data-model-id'=> $model->id
                 ]);
             },
             'delete' => function ($url, $model) {
                 return Html::a('<span class="glyphicon glyphicon-trash"></span>', null, [
                     'title' => Yii::t('app', 'lead-delete'),
                     'class'=>'deleteModalButton',
                     'data-model-id'=> $model->id
                 ]);
             }
         ],
        ],
    ],

]);?>
<?php Pjax::end(); ?>

<?php
Modal::begin([
    'header' => '<h1>Добавление элемента</h1>',
    'id' => 'addElementModal',
    'size' => 'modal-lg',
    'toggleButton' => ['label' => 'Добавить элемент'],
]);?>

<?php Pjax::begin(['id' => 'new_note']); ?>

<div style="display: none;" id="currentPage" value=<?php echo $curPage;?>></div>

    <?php $form = ActiveForm::begin([
        'id' => 'my-form-id',
        'enableAjaxValidation' => true,
        'action' => 'game-screen',
        'validationUrl' => 'validate',
        'options' => ['data-pjax' => true]
    ]); ?>
    <?= $form->field($model, 'text') ?>
    <?= $form->field($model, 'choice0') ?>
    <?= $form->field($model, 'choice1') ?>
    <?= $form->field($model, 'choice2') ?>
    <?= $form->field($model, 'choice3') ?>
    <?= $form->field($model, 'correct_choice') ?>
    <?= Html::submitButton('Save') ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
<?php Modal::end(); ?>


<?php
Modal::begin([
    'header' => '<h1></h1>',
    'id' => 'deleteModal',
    'size' => 'modal-lg',
]);

echo "<div style='display: none'></div>";
echo "<div>Удалить выбранный элемент?</div>";
echo "<div class='btn btn-default' id='delete_element'>Удалить</div>";

Modal::end();
?>

<?php
$js = <<<JS
     var currentQuestionId;
    
    $( document ).ready(function() {
            $("#new_note").on("pjax:end", function() { 
                $.pjax.reload({container:"#notes", url:"game-screen?page=" + $('#currentPage').attr('value')});  //Reload GridView  
            });   
            
            $('.deleteModalButton').click(function(){                
                $('#deleteModal').modal('show');
                currentQuestionId = $(this).attr("data-model-id");                               
            }); 
            
            $('.updateModalButton').click(function(){                
                $('#addElementModal').modal('show');
                currentQuestionId = $(this).attr("data-model-id");  
                
                console.log('currentQuestionId =' + currentQuestionId);
            }); 
            
            
            $("#delete_element").click(function() {
               
              $.ajax({
                 url: '/zatesti/web/index.php/game-screen/delete-item',
                 type: 'POST',
                 data:{
                     'item_id': currentQuestionId,
                 },
                 success: function(res){ 
                         $('#deleteModal').modal('hide');
                         $.pjax.reload({container:"#notes", url:"game-screen?page=" + $('#currentPage').attr('value')});  //Reload GridView  
                 },
                 error: function(){
                 alert('Error!');
                 }
            });  
            })
            
            
       });


    $(document).on('pjax:complete', function() {
            $('.deleteModalButton').click(function(){                                
                $('#deleteModal').modal('show');
                currentQuestionId = $(this).attr("data-model-id");
            });  
     });


JS;
$this->registerJs($js);
?>

