<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */

$this->title = 'Application';
?>
<div class="site-index">

    <div class="jumbotron">
    </div>
    <div class="body-content">
        <?= Html::a('Add Meeting',  Url::to(['site/addmeeting']), ['class' => 'btn btn-sm btn-success pull-right add-meeting']) ?>
        <div class="row">
            <div class="col-md-3">
                
                <?php if($activeUsers != NULL) { ?>
                    <h5 class="text-center">Users</h5>
                    <?php foreach($activeUsers as $key => $user) { ?>
                    <div class="well well-sm text-center activeuser" data-id="<?= $user->id; ?>" style="cursor: pointer;"><?= $user->name; ?></div>
                <?php } } ?>
            </div>

            <div class="col-md-8">
            <?= edofre\fullcalendar\Fullcalendar::widget([
                'clientOptions' => [
                    // 'defaultView' => 'agendaWeek',
                    // 'eventResize' => new JsExpression("
                    //     function(event, delta, revertFunc, jsEvent, ui, view) {
                    //         console.log(event);
                    //     }
                    // "),        
                ],
                    'events' => Url::to(['site/events']),
                ]);
            ?>
        </div>
        </div>

    </div>
</div>
<?php
        Modal::begin([
                'header'=>'<h4>Add Meeting</h4>',
                'id' => 'add-meeting',
                'size'=>'modal-md',
            ]);
     
        echo "<div id='modalContent'></div>";
     
        Modal::end();
    ?>
<?php
$start_date = date("Y-m-d");
$end_date = date("Y-m-d", strtotime($start_date. ' + 30 days'));
$script = <<< JS
$('.activeuser').click(function(){
    var user_id = $(this).attr("data-id");
    $.ajax({
              type: 'GET',
              url: './index.php?r=site%2Fevents',
              data: {user_id : user_id,start:'$start_date',end:'$end_date'},
              success: function( response ) {
                if(response != "") {
                    $('#calendar').fullCalendar('removeEvents');
                     $('#calendar').fullCalendar('addEventSource',response);
                    } else {
                       $('#calendar').fullCalendar('removeEvents');
                    }
              }
          });
    
});
$('.add-meeting').click(function (e){
    e.preventDefault();
        $('#add-meeting').modal('show')
            .find('#modalContent')
            .load($(this).attr('href'));
    });
JS;
$this->registerJs($script);
?>