<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use common\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Attendance */

?>
<?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>
<div class="row">
<div class="col-md-12">
<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-md-6">
<?= $form->field($model, 'date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Date','autocomplete'=>'off'],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true,
        'startDate' => 'd',
    ]
]);?>
</div>
<div class="col-md-6">
<?= $form->field($model, 'start_time')->widget(TimePicker::classname(), [
    'options' => ['value'=> '00:00'],
    'pluginOptions' => [
        'showSeconds' => false,
        'showMeridian' => false,
        'minuteStep' => 5,
    ]
]);?>
</div>
<div class="col-md-12">
<?= $form->field($model, 'duration')->textInput(['placeholder' => 'Duration in Minutes']) ?>
</div>
<div class="col-md-12">
        <?= $form->field($modelAttendees, 'attendee_id[]')->widget(Select2::classname(), [
        'language' => 'en',
        // 'value' => $model->client_id,
        'data' => ArrayHelper::map( User::find()->where(['status' => 1])->andWhere(['!=','id', Yii::$app->user->identity->id])->all(), 'id', 'name'),
        'options' => ['placeholder' => '-- Please Select --'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
        ],
    ]); ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$script = <<< JS

$('form#{$model->formName()}').on('beforeSubmit', function(e) 
{

   var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize Yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result != '')
        {
            setTimeout(function(){ 
                $('#add-meeting').modal('hide'); 
                 }, 100);
                 
                 $('#calendar').fullCalendar('addEventSource',result);
            
        } else {
            alert('Selected users may have another meeting on time.!');
            $('#add-meeting').modal('hide'); 
        }
        }).fail(function() 
        {
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
?>