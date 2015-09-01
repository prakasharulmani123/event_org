<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MyHtml extends CHtml {
    public static function link($label, $url, $htmlOptions = array()) {
        $exp = explode("/", $url[0]);
        $group_role = NULL;
        if(count($exp) == 1){
            $controller = Yii::app()->controller->id;
            $action = $url[0];
        }else{
            $controller = $exp[2];
            $action = $exp[3];
        }

        if(UserIdentity::checkAccess(NULL, $controller, $action))
            return CHtml::link($label, $url, $htmlOptions);
    }
}
