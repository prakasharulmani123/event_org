<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$mode = isset($_REQUEST['mode']) ? mysql_real_escape_string($_REQUEST['mode']) : '';

if ($mode == "login") {
    $status = false;
    $result = array();
    $username = isset($_REQUEST['username']) ? mysql_real_escape_string($_REQUEST['username']) : '';
    $password = isset($_REQUEST['password']) ? mysql_real_escape_string($_REQUEST['password']) : '';

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

            $result['user_firstname'] = $firstname;
            $result['user_id'] = $user_id;
            $result['role'] = $role;
        }
    }

    $response = array_merge(array('status' => $status), array_filter($result));
    echo json_encode($response, true);
    die;
}

if ($mode == "eventlist") {


    $userid = isset($_REQUEST['userid']) ? mysql_real_escape_string($_REQUEST['userid']) : '';

    $status = true;
    $result = array();
    $select_events = "SELECT * from `evt_event` where status='1' and created_by='$userid' ORDER BY event_date ";
    $result_events = mysql_query($select_events);
    $count = mysql_num_rows($result_events);

    if ($count > 0) {
        $k = 0;
        while ($row_event = mysql_fetch_assoc($result_events)) {
            $event_id = $row_event ['event_id'];
            $event_name = $row_event ['event_name'];
            $event_date = $row_event ['event_date'];

            $result_event[$k]['event_id'] = $event_id;
            $result_event[$k]['event_name'] = $event_name;
            $result_event[$k]['event_date'] = $event_date;



            $select_event_lists = "SELECT el.*,er.role_name FROM `evt_event_lists` AS el, evt_role AS er WHERE el.list_role=er.role_id AND el.event_id='$event_id' AND er.status='1' ORDER BY el.timing_start ASC";
            $result_event_lists = mysql_query($select_event_lists);
            $count_lists = mysql_num_rows($result_event_lists);
            if ($count_lists > 0) {
                $j = 0;
                while ($row_eventlist = mysql_fetch_assoc($result_event_lists)) {
                    $timing_id = $row_eventlist['timing_id'];
                    $event_type = ($row_eventlist['event_type'] == 'FX') ? 'Fixed' : 'Flexible';
                    $_event[$j]['list_title'] = $row_eventlist['list_title'];
                    $_event[$j]['role_name'] = $row_eventlist['role_name'];
                    $_event[$j]['event_type'] = $event_type;
                    $_event[$j]['timing_start'] = date('h:i A', strtotime($row_eventlist['timing_start']));
                    $j++;
                }
                $result_event[$k]['event_cats'] = $_event;
            }

            $k++;
        }

        $result['all_events'] = $result_event;
    }

    $response = array_merge(array('status' => $status), array_filter($result));
    echo json_encode($response, true);
    die;
}

if ($mode == "vendorslist") {
    $userid = isset($_REQUEST['userid']) ? mysql_real_escape_string($_REQUEST['userid']) : '';

    $get_query = ($userid > 0 && $userid != '') ? " and created_by='$userid' " : "";

    $status = true;
    $result = array();
    $select_events = "SELECT * from `evt_event` where status='1' $get_query ORDER BY event_date ";
    $result_events = mysql_query($select_events);
    $count = mysql_num_rows($result_events);

    if ($count > 0) {
        $k = 0;
        while ($row_event = mysql_fetch_assoc($result_events)) {

            $event_id = $row_event ['event_id'];
            $event_name = $row_event ['event_name'];
            $event_date = $row_event ['event_date'];

            $result_vendor[$k]['event_id'] = $event_id;
            $result_vendor[$k]['event_name'] = $event_name;

            $select_vendor_lists = "SELECT e.event_id,e.event_name,e.event_date,evt_vendor,evt_vendor_name,evt_vendor_email,ev.evt_vendor_phone,er.role_name FROM evt_event AS e , evt_event_vendors AS ev , evt_role AS er WHERE e.event_id=ev.ev_event_id AND ev.evt_vendor_role=er.role_id AND e.status='1' AND ev.ev_event_id='$event_id' ORDER BY e.event_date ASC,ev.evt_vendor ASC ";
            $result_vendor_lists = mysql_query($select_vendor_lists);
            $count_vendorlists = mysql_num_rows($result_vendor_lists);
            if ($count_vendorlists > 0) {
                $j = 0;
                while ($row_vendorlist = mysql_fetch_assoc($result_vendor_lists)) {
                    $_vendor[$j]['vendor_id'] = $row_vendorlist['evt_vendor'];
                    $_vendor[$j]['vendor_name'] = $row_vendorlist['evt_vendor_name'];
                    $_vendor[$j]['vendor_email'] = $row_vendorlist['evt_vendor_email'];
                    $_vendor[$j]['vendor_phone'] = $row_vendorlist['evt_vendor_phone'];
                    $_vendor[$j]['vendor_role'] = $row_vendorlist['role_name'];
                    ;
                    $j++;
                }
                $result_vendor[$k]['vendors'] = $_vendor;
            }
            $k++;
        }

        $result['all_vendors_events'] = $result_vendor;
    }

    $response = array_merge(array('status' => $status), array_filter($result));
    echo json_encode($response, true);
    die;
}