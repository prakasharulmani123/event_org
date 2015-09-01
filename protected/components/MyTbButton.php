<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('booster.widgets.TbButton');
Yii::import('application.components.UserIdentity');

/**
 * Description of MyActionButton
 *
 * @author Admin
 */
class MyTbButton extends TbButton{
    
    public function init() {
        $this->visible = UserIdentity::checkAccess();
        parent::init();
    }

//    public function UrlToController($url) {
//        if (is_array($url)) {
//            if (isset($url[0])) {
//                $route = explode('/', $url[0]);
//                $count = count($route);
//                var_dump($route);
//                echo "Action: ". $action = end($route);
//                echo "<br />Controller: ". $controller = prev($route);
//                if($controller == null){
//                echo "<br />Controller: ". $controller = Yii::app()->controller->id;                    
//                }
//                echo "<br />Module: ". $module = prev($route);
//                exit;
////                if (($c = Yii::app()->getController()) !== null){
////                    $url = $c->createUrl($url[0], array_splice($url, 1));
////                    var_dump($url);
////                    exit;
////                    }else{
////                    $url = Yii::app()->createUrl($url[0], array_splice($url, 1));
////                }
//            } else
//                $url = '';
//        }
//        return $url === '' ? Yii::app()->getRequest()->getUrl() : $url;
//    }

}
