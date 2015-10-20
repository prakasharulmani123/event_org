<?php

include_once 'includes/config.php';
include_once 'includes/functions.php';
$result = array();
$username = isset($_REQUEST['username']) ? filter_input(INPUT_REQUEST, 'username', FILTER_VALIDATE_EMAIL) : '';
$password = isset($_REQUEST['password']) ? filter_input(INPUT_REQUEST, 'password') : '';

if (!empty($username) && !empty($password)) {
    $password = encrypt_pass($password);
    $select_users = "SELECT * from `evt_user` where (username='{$username}' OR `user_email`='{$username}') and `password_hash`= '{$password}'";
    $result_users = mysql_query($select_users);
    $count = mysql_num_rows($result_users);
    if ($count == 1) {
        $row_users = mysql_fetch_assoc($result_users);
        $user_id = $row_users['user_id'];
        $role = $row_users['role_id'];

        $result['user_firstname'] = $row_users['user_firstname'];
        $status = 1;
    } else {
        $role = "NULL";
        $user_id = 0;
        $status = 0;
    }
    $result['status'] = $status;

    $result['user_id'] = $user_id;
    $result['role'] = $role;
}

echo json_encode($result, true);

