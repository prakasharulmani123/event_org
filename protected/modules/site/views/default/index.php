<?php
$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
?>

<div class="row states-info">
    <div class="col-md-3">
        <div class="panel red-bg">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="col-xs-8">
                        <span class="state-title"> Users </span>
                        <h4><?php echo $user_count = User::model()->count(); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel blue-bg">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-tag"></i>
                    </div>
                    <div class="col-xs-8">
                        <span class="state-title">  Timelines  </span>
                        <h4><?php echo $event_count = Event::model()->count(); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--            <div class="col-md-3">
                    <div class="panel green-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-gavel"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  New Order  </span>
                                    <h4>5980</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel yellow-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-eye"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Unique Visitors  </span>
                                    <h4>10,000</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                <div class="calendar-block ">
                    <div class="cal1">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <header class="panel-heading">
                Timeline progress
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <ul class="goal-progress">
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($this->themeUrl.'/images/photos/user1.png', $alt); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#">John Doe</a> - Project Lead
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                    <span class="">70%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($this->themeUrl.'/images/photos/user2.png', $alt); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#">Cameron Doe</a> - Sales
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 91%">
                                    <span class="">91%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($this->themeUrl.'/images/photos/user3.png', $alt); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#">Hoffman Doe</a> - Support
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="">40%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($this->themeUrl.'/images/photos/user4.png', $alt); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#">Jane Doe</a> - Marketing
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="">20%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($this->themeUrl.'/images/photos/user5.png', $alt); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#">Hoffman Doe</a> - Support
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                    <span class="">45%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="text-center"><a href="#">View all Goals</a></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
                    <div class="panel">
                        <header class="panel-heading">
                            Todo List
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                                <a class="fa fa-times" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <ul class="to-do-list" id="sortable-todo">
                                <li class="clearfix">
                                    <span class="drag-marker">
                                    <i></i>
                                    </span>
                                    <div class="todo-check pull-left">
                                        <input type="checkbox" value="None" id="todo-check"/>
                                        <label for="todo-check"></label>
                                    </div>
                                    <p class="todo-title">
                                        Dashboard Design & Wiget placement
                                    </p>
                                    <div class="todo-actionlist pull-right clearfix">

                                        <a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <span class="drag-marker">
                                    <i></i>
                                    </span>
                                    <div class="todo-check pull-left">
                                        <input type="checkbox" value="None" id="todo-check1"/>
                                        <label for="todo-check1"></label>
                                    </div>
                                    <p class="todo-title">
                                        Wireframe prepare for new design
                                    </p>
                                    <div class="todo-actionlist pull-right clearfix">

                                        <a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <span class="drag-marker">
                                    <i></i>
                                    </span>
                                    <div class="todo-check pull-left">
                                        <input type="checkbox" value="None" id="todo-check2"/>
                                        <label for="todo-check2"></label>
                                    </div>
                                    <p class="todo-title">
                                        UI perfection testing for Mega Section
                                    </p>
                                    <div class="todo-actionlist pull-right clearfix">

                                        <a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <span class="drag-marker">
                                    <i></i>
                                    </span>
                                    <div class="todo-check pull-left">
                                        <input type="checkbox" value="None" id="todo-check3"/>
                                        <label for="todo-check3"></label>
                                    </div>
                                    <p class="todo-title">
                                        Wiget & Design placement
                                    </p>
                                    <div class="todo-actionlist pull-right clearfix">

                                        <a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <span class="drag-marker">
                                    <i></i>
                                    </span>
                                    <div class="todo-check pull-left">
                                        <input type="checkbox" value="None" id="todo-check4"/>
                                        <label for="todo-check4"></label>
                                    </div>
                                    <p class="todo-title">
                                        Development & Wiget placement
                                    </p>
                                    <div class="todo-actionlist pull-right clearfix">

                                        <a href="#" class="todo-remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </li>

                            </ul>
                            <div class="row">
                                <div class="col-md-12">
                                    <form role="form" class="form-inline">
                                        <div class="form-group todo-entry">
                                            <input type="text" placeholder="Enter your ToDo List" class="form-control" style="width: 100%">
                                        </div>
                                        <button class="btn btn-success pull-right" type="submit">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<?php
$cs = Yii::app()->getClientScript();
$themeUrl = $this->themeUrl;
$cs_pos_end = CClientScript::POS_END;
$cs->registerScriptFile($themeUrl . '/js/calendar/clndr.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/calendar/evnt.calendar.init.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/calendar/moment-2.2.1.js', $cs_pos_end);
$cs->registerScriptFile('http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js', $cs_pos_end);

$js = <<< EOD
$(function(){
});
EOD;
$cs->registerCssFile($themeUrl . '/css/clndr.css');
?>