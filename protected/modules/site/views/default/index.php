<?php
$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
?>

<div class="row states-info">
    <div class="col-md-5">
        <div class="panel red-bg">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="col-xs-8">
                        <span class="state-title"> Users </span>
                        <h4><?php echo $user_count = User::model()->active()->count(); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
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
    <!--    <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <div class="calendar-block ">
                        <div class="cal1">

                        </div>
                    </div>

                </div>
            </div>
        </div>-->
    <div class="col-md-5">
        <div class="panel">
            <header class="panel-heading">Users</header>
            <div class="panel-body">
                <ul class="goal-progress">
                    <?php
                    $users = User::model()->active()->findAll();
                    foreach($users as $user):
                    ?>
                    <li>
                        <div class="prog-avatar">
                            <?php echo CHtml::image($user->avatar, Yii::app()->user->name); ?>
                        </div>
                        <div class="details">
                            <div class="title">
                                <a href="#"><?php echo $user->fullname; ?></a>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <!--<div class="text-center"><a href="#">View all Goals</a></div>-->
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <div class="panel">
            <header class="panel-heading">Timelines</header>
            <div class="panel-body">
                <ul class="goal-progress">
                    <?php
                    $events = Event::model()->active()->findAll();
                    foreach($events as $event):
                    ?>
                    <li>
                        <div class="details">
                            <div class="title">
                                <a href="#"><?php echo $event->event_name; ?></a> on <?php echo $event->event_date; ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <!--<div class="text-center"><a href="#">View all Goals</a></div>-->
            </div>
        </div>
    </div>
    <!--    <div class="col-md-5">
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
                    </div>-->
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