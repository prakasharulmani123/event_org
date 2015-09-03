<td>
    <?php echo CHtml::activeTextField($model, "[$index]list_title", array("class" => "form-control")); ?>
    <?php echo CHtml::error($model, "[$index]list_title"); ?>
</td>
<td>
    <div class="input-group bootstrap-timepicker">
        <?php echo CHtml::activeTextField($model, "[$index]timing_start", array("class" => "form-control timepicker-default")); ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
        </span>
    </div>
    <?php echo CHtml::error($model, "[$index]timing_start"); ?>
</td>
<td>
    <div class="input-group bootstrap-timepicker">
        <?php echo CHtml::activeTextField($model, "[$index]timing_end", array("class" => "form-control timepicker-default")); ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
        </span>
    </div>
    <?php echo CHtml::error($model, "[$index]timing_end"); ?>
</td>