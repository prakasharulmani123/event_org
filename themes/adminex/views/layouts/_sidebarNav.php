<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo-text">
        <h3><?php echo SITENAME; ?></h3>
    </div>
<!--    <div class="logo">
        <a href="index.html"><img src="images/logo.png" alt=""></a>
    </div>
    <div class="logo-icon text-center">
        <a href="index.html"><img src="images/logo_icon.png" alt=""></a>
    </div>-->
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <?php // echo CHtml::image("{$this->themeUrl}/images/photos/user-avatar.png", '', array('class'=>"media-object")); ?>
                <!--<img alt="" src="images/photos/user-avatar.png" class="media-object">-->
                <div class="media-body">
                    <h4><a href="#">John Doe</a></h4>
                    <span>"Hello There..."</span>
                </div>
            </div>

            <h5 class="left-nav-title">Account Information</h5>
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>

        <!--sidebar nav start-->
        <?php
        $is_admin = UserIdentity::checkAdmin();
        $this->widget('application.components.MyMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => array('/site/default/index'), 'visible' => $is_admin),
                array('label' => '<i class="fa fa-cog"></i> <span>Administration</span>', 'url' => '#',
                    'itemOptions' => array('class' => 'menu-list'),
                    'submenuOptions' => array('class' => 'sub-menu-list'),
                    'items' => array(
                        array('label' => '<span>Role</span>', 'url' => array('/site/role/index'), 'visible' => $is_admin, 'active' => '0'),
                        array('label' => '<span>User</span>', 'url' => array('/site/user/index'), 'visible' => $is_admin, 'active' => '0'),
                        array('label' => '<span>Event</span>', 'url' => array('/site/event/index'), 'visible' => '1', 'active' => '0'),
                    ),
                ),
            ),
            'htmlOptions' => array('class' => 'nav nav-pills nav-stacked custom-nav')
        ));
        ?>
        <!--sidebar nav end-->

    </div>
</div>

