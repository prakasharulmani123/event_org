<?php
/* @var $this UserController */
/* @var $model User */

if ($profile) {
    $this->title = 'My Profile';
} else {
    $this->title = 'Update Users: ' . $model->user_id;
    $this->breadcrumbs = array(
        'Users' => array('index'),
        'Update Users',
    );
}
?>

<div class="user-create">
<?php $this->renderPartial('_form', array('model' => $model,'profile' => $profile)); ?></div>