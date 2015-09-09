<div class="header-section">

    <!--toggle button start-->
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <!--toggle button end-->

    <!--search start-->
    <!--    <form class="searchform" action="index.html" method="post">
            <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
        </form>-->
    <!--search end-->

    <!--notification menu start -->
    <div class="menu-right">
        <ul class="notification-menu">
            <!--            <li>
                            <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="badge">8</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-head pull-right">
                                <h5 class="title">You have 8 pending task</h5>
                                <ul class="dropdown-list user-list">
                                    <li class="new">
                                        <a href="#">
                                            <div class="task-info">
                                                <div>Database update</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                    <span class="">40%</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="task-info">
                                                <div>Dashboard done</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar progress-bar-success">
                                                    <span class="">90%</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="task-info">
                                                <div>Web Development</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div style="width: 66%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="66" role="progressbar" class="progress-bar progress-bar-info">
                                                    <span class="">66% </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="task-info">
                                                <div>Mobile App</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div style="width: 33%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="33" role="progressbar" class="progress-bar progress-bar-danger">
                                                    <span class="">33% </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="task-info">
                                                <div>Issues fixed</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div style="width: 80%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar">
                                                    <span class="">80% </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new"><a href="">See All Pending Task</a></li>
                                </ul>
                            </div>
                        </li>-->
            <!--            <li>
                            <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-head pull-right">
                                <h5 class="title">You have 5 Mails </h5>
                                <ul class="dropdown-list normal-list">
                                    <li class="new">
                                        <a href="">
                                            <span class="thumb"><img src="images/photos/user1.png" alt="" /></span>
                                            <span class="desc">
                                                <span class="name">John Doe <span class="badge badge-success">new</span></span>
                                                <span class="msg">Lorem ipsum dolor sit amet...</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span class="thumb"><img src="images/photos/user2.png" alt="" /></span>
                                            <span class="desc">
                                                <span class="name">Jonathan Smith</span>
                                                <span class="msg">Lorem ipsum dolor sit amet...</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span class="thumb"><img src="images/photos/user3.png" alt="" /></span>
                                            <span class="desc">
                                                <span class="name">Jane Doe</span>
                                                <span class="msg">Lorem ipsum dolor sit amet...</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span class="thumb"><img src="images/photos/user4.png" alt="" /></span>
                                            <span class="desc">
                                                <span class="name">Mark Henry</span>
                                                <span class="msg">Lorem ipsum dolor sit amet...</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <span class="thumb"><img src="images/photos/user5.png" alt="" /></span>
                                            <span class="desc">
                                                <span class="name">Jim Doe</span>
                                                <span class="msg">Lorem ipsum dolor sit amet...</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="new"><a href="">Read All Mails</a></li>
                                </ul>
                            </div>
                        </li>-->
            <li>
                <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                    <i class="fa fa-clock-o"></i>
                    <!--<span class="badge">4</span>-->
                </a>
                <?php $histories = EventHistory::model()->mine()->findAll(array('limit' => 5, 'order' => 'created_at desc')) ?>
                <?php if (!empty($histories)) { ?>
                    <div class="dropdown-menu dropdown-menu-head pull-right">
                        <h5 class="title">Latest Event Histories</h5>
                        <ul class="dropdown-list normal-list">
                            <?php foreach ($histories as $history): ?>
                                <li class="new">
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/site/event/view', array('id' => $history->eventList->event_id)); ?>">
                                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                        <span class="name">
                                            <b><?php echo $history->eventList->list_title; ?></b><br />
                                            Reason: <?php echo (strlen($history->event_hist_reason) > 100) ? substr($history->event_hist_reason,0,97).'...' : $history->event_hist_reason; ?><br />
                                        </span>
                                        <em class="small"><?php echo $history->historytype($history->event_hist_type) ?>: <?php echo $history->event_hist_excess_time; ?></em>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <!--<li class="new"><a href="">See All Notifications</a></li>-->
                        </ul>
                    </div>
                <?php } ?>
            </li>
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <?php echo CHtml::image("{$this->themeUrl}/images/avatar5.png", '', array()); ?>
                    <?php echo Yii::app()->user->name; ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <li><?php echo CHtml::link('<i class="fa fa-user"></i>  Profile', array('/site/default/profile'), array()); ?></li>
                    <li><?php echo CHtml::link('<i class="fa fa-sign-out"></i> Log out', array('/site/default/logout'), array()) ?></li>
                </ul>
            </li>

        </ul>
    </div>
    <!--notification menu end -->
</div>

<div class="page-heading">
    <h3>
        <?php
        if ($this->title !== null) {
            echo Inflector::camel2words($this->title);
        } else {
            echo Inflector::camel2words(Inflector::id2camel($this->context->module->id));
            echo ($this->context->module->id !== Yii::app()->id) ? '<small>Module</small>' : '';
        }
        ?>
    </h3>
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
        'tagName' => 'ul', // container tag
        'htmlOptions' => array('class' => 'breadcrumb'), // no attributes on container
        'separator' => '', // no separator
        'homeLink' => '<li><a href="' . Yii::app()->baseUrl . '/site/default/index"><i class="fa fa-home"></i> Home</a></li>', // home link template
        'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // active link template
        'inactiveLinkTemplate' => '<li class="active">{label}</li>', // in-active link template
    ));
    ?>
</div>
