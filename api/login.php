<?php

include_once 'includes/config.php';
include_once 'includes/functions.php';
$result = array();
$username = isset($_REQUEST['username']) ? mysql_real_escape_string($_REQUEST['username']) : '';
$password = isset($_REQUEST['password']) ? mysql_real_escape_string($_REQUEST['password']) : '';
$status = false;

if (!empty($username) && !empty($password)) {
    $password = encrypt_pass($password);
    $select_users = "SELECT * from `evt_user` where (username='{$username}' OR `user_email`='{$username}') and `password_hash`= '{$password}'";
    $result_users = mysql_query($select_users);
    $count = mysql_num_rows($result_users);
    if ($count == 1) {
        $row_users = mysql_fetch_assoc($result_users);
        $firstname = $row_users['user_firstname'];
        $user_id = $row_users['user_id'];
        $role = $row_users['role_id'];

        $status = true;
    }

    $result['user_firstname'] = $firstname;
    $result['user_id'] = $user_id;
    $result['role'] = $role;
}

$response = array_merge(array('status'=>$status),array_filter($result));
echo json_encode($response, true);