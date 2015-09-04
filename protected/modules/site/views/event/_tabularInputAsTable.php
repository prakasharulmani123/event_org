<td>
    <?php echo CHtml::activeTextField($model, "[$index]list_title", array("class" => "form-control", 'size' => '350')); ?>
    <?php echo CHtml::error($model, "[$index]list_title"); ?>
</td>
<td>
    <div class="input-group bootstrap-timepicker">
        <?php echo CHtml::activeTextField($model, "[$index]timing_start", array("class" => "form-control timepicker-default", 'id' => "timing_start$index")); ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
        </span>
    </div>
    <?php echo CHtml::error($model, "[$index]timing_start"); ?>
</td>
<td>
    <div class="input-group bootstrap-timepicker">
        <?php echo CHtml::activeTextField($model, "[$index]timing_end", array("class" => "form-control timepicker-default", 'id' => "timing_end$index"/*, 'value' => date('h:i A', strtotime($model->timing_end))*/)); ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
        </span>
    </div>
    <?php echo CHtml::error($model, "[$index]timing_end"); ?>
</td>

                                
<?php
$cs = Yii::app()->getClientScript();
$start_date = date('h:i A', strtotime($model->timing_start));
$end_date = date('h:i A', strtotime($model->timing_end));

$js = <<< EOD
var start_time = '$start_date';
var end_time = '$end_date';
$(function(){
    if(start_time != ''){
        $('#timing_start$index').timepicker({
            defaultTime: '$start_date'
        });
    }
    if(end_time != ''){
        $('#timing_end$index').timepicker({
            defaultTime: '$end_date'
        });
    }
});
EOD;
$cs->registerScript("_event_list__form$index", $js);
?>