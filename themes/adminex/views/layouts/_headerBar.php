<div class="header-section">
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <div class="menu-right">
        <ul class="notification-menu">

            <li>
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
                                            Reason: <?php echo (strlen($history->event_hist_reason) > 100) ? substr($history->event_hist_reason, 0, 97) . '...' : $history->event_hist_reason; ?><br />
                                        </span>
                                        <em class="small"><?php echo $history->historytype($history->event_hist_type) ?>: <?php echo $history->event_hist_excess_time; ?></em>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php } ?>
            </li>
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <?php
                    $uAvatar = UPLOAD_DIR . str_replace("\\", "/", User::model()->findByPk(Yii::app()->user->id)->user_avatar);

                    if (!file_exists($uAvatar) || !is_file($uAvatar)) {
                        $uAvatar = "{$this->themeUrl}/images/avatar5.png";
                    } else {
                        $uAvatar = $this->createUrl("/" . $uAvatar);
                    }

                    echo CHtml::image($uAvatar, Yii::app()->user->name, array());

                    echo Yii::app()->user->name; ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <li><?php echo CHtml::link('<i class="fa fa-user"></i>  Profile', array('/site/default/profile'), array()); ?></li>
                    <li><?php echo CHtml::link('<i class="fa fa-sign-out"></i> Log out', array('/site/default/logout'), array()) ?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<?php if ($this->title): ?>
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
//    $this->widget('zii.widgets.CBreadcrumbs', array(
//        'links' => $this->breadcrumbs,
//        'tagName' => 'ul', // container tag
//        'htmlOptions' => array('class' => 'breadcrumb'), // no attributes on container
//        'separator' => '', // no separator
//        'homeLink' => false,
////        'homeLink' => '<li><a href="' . Yii::app()->baseUrl . '/site/default/index"><i class="fa fa-home"></i> Home</a></li>', // home link template
//        'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // active link template
//        'inactiveLinkTemplate' => '<li class="active">{label}</li>', // in-active link template
//    ));
        ?>
    </div>
<?php endif; ?>
