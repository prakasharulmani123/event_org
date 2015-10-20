<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$result1   = array();
$useremail = isset($_REQUEST['email'])?$_REQUEST['email']:'';
$password  = isset($_REQUEST['password'])?$_REQUEST['password']:'';

if($useremail!='' && $password!='')
{    
    $password  = encrypt_pass($password);
    $select_users="SELECT * from `evt_user` where `user_email`='$useremail' and `password_hash`='$password'";
    $result_users=mysql_query($select_users);
    $count=mysql_num_rows($result_users);
    if($count==1)
    {
            $row_users = mysql_fetch_assoc($result_users);
            $user_id   = $row_users['user_id'];
            $role      = $row_users['role_id'] ;
            
            $result1['user_firstname']=$row_users['user_firstname'];
            $message   = "SUCCESS";
            $success   = 1;
            
    }else{
            $role="NULL";
            $user_id=0;
            $message="FAILURE";
            $success=0;

    }
    $result1['user_id']=$user_id;    
    $result1['role']=$role;
    $result1['message']=$message;
    $result1['success']=$success;
}

echo json_encode($result1,true);

