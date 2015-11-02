<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebServicesAPI
 *
 * @author ARK-9
 */
class WebServicesAPI {

    private $db;
    public $status = false;
    public $result = array();

    function __construct() {
        date_default_timezone_set("Asia/Kolkata");

        $whitelist = array('127.0.0.1', '::1');
        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $dbname = "event_org";
        } else {
            $hostname = "localhost";
            $username = "rajencba_prakash";
            $password = "&Fzk*^A1rd%T";
            $dbname = "rajencba_event_org";
        }
        $this->db = new mysqli($hostname, $username, $password, $dbname);
        $this->db->autocommit(FALSE);
    }

    // Destructor - close DB connection
    function __destruct() {
        $this->db->close();
    }

    function login() {
        $this->result = array('msg' => "Incorrect username/password");
        $username = isset($_REQUEST['username']) ? $this->db->real_escape_string($_REQUEST['username']) : '';
        $password = isset($_REQUEST['password']) ? $this->db->real_escape_string($_REQUEST['password']) : '';
        $device_token = isset($_REQUEST['devicetoken']) ? $this->db->real_escape_string($_REQUEST['devicetoken']) : '';


        if (!empty($username) && !empty($password) && !empty($device_token)) {
            $password = encrypt_pass($password);
            $record = $this->db->query("SELECT * from `evt_user` where (username ='{$username}' OR `user_email`= '{$username}') and `password_hash`= '{$password}'");
            if ($record->num_rows == 1) {
                $row_users = $record->fetch_assoc();
                $firstname = $row_users['user_firstname'];
                $userid = $row_users['user_id'];
                $role = $row_users['role_id'];

                $device_record = $this->db->query("SELECT * from `evt_deviceinfos` where `user_id`= '{$userid}'");
                if ($device_record->num_rows == 1) {
                    $query = "UPDATE `evt_deviceinfos` SET `device_token` = '$device_token' WHERE `user_id` = $userid";
                } else {
                    $query = "INSERT INTO `evt_deviceinfos` (`device_token`, `user_id`, `created_date`) VALUES ('$device_token', '$userid', now())";
                }
                $insert_row = $this->db->query($query);
                $this->db->commit();

                $this->status = true;
                $this->result['msg'] = "Successfully logged in";
                $this->result['user_firstname'] = $firstname;
                $this->result['user_id'] = $userid;
                $this->result['first_event_id'] = $this->_get_event_by_userid($userid)[0];

                $this->result['role'] = $role;
            }
            $record->free();
        }
    }

    function eventlist() {
        $userid = isset($_REQUEST['userid']) ? $this->db->real_escape_string($_REQUEST['userid']) : '';
        $event_ids = implode(',', $this->_get_event_by_userid($userid));
        $record = $this->db->query("SELECT * from `evt_event` where status='1' and event_id IN ({$event_ids}) ORDER BY event_date");

        if ($record->num_rows > 0) {
            $k = 0;
            while ($row_event = $record->fetch_assoc()) {
                $event_id = $row_event ['event_id'];
                $event_name = $row_event ['event_name'];
                $event_date = $row_event ['event_date'];

                $result_event[$k]['event_id'] = $event_id;
                $result_event[$k]['event_name'] = $event_name;
                $result_event[$k]['event_date'] = $event_date;
                $result_event[$k]['event_cats'] = $this->eventlist_sub($event_id);

                $k++;
            }
            $this->status = true;
            $this->result['all_events'] = $result_event;
            $record->free();
        }
    }

    function eventlist_sub($event_id = null, $direct = false) {
        if (is_null($event_id)) {
            $event_id = isset($_REQUEST['event_id']) ? $this->db->real_escape_string($_REQUEST['event_id']) : '';
            $direct = true;
        }
        $record_list = $this->db->query("SELECT el.*,er.role_name FROM `evt_event_lists` AS el, evt_role AS er WHERE el.list_role=er.role_id AND el.event_id='$event_id' AND er.status='1' ORDER BY el.timing_start ASC");

        if ($record_list->num_rows > 0) {
            $j = 0;
            while ($row_eventlist = $record_list->fetch_assoc()) {
                $timing_id = $row_eventlist['timing_id'];
                $event_type = ($row_eventlist['event_type'] == 'FX') ? 'Fixed' : 'Flexible';
                $_event[$j]['list_title'] = $row_eventlist['list_title'];
                $_event[$j]['role_name'] = $row_eventlist['role_name'];
                $_event[$j]['event_type'] = $event_type;
                $_event[$j]['timing_start'] = date('h:i A', strtotime($row_eventlist['timing_start']));
                $_event[$j]['created_user'] = array('user_id' => $row_eventlist['created_by'], 'name' => $this->_get_user_info($row_eventlist['created_by'])['user_firstname']);
                $_event[$j]['assigned_users'] = $this->_users_assignment($row_eventlist['timing_id']);
                $j++;
            }
            if ($direct):
                $this->status = true;
                $this->result = array("event_cats" => $_event);
            else:
                return $_event;
            endif;
            $record_list->free();
        }
    }

    function vendorslist() {
        $userid = isset($_REQUEST['userid']) ? $this->db->real_escape_string($_REQUEST['userid']) : '';
        $event_ids = implode(',', $this->_get_event_by_userid($userid));
        $record = $this->db->query("SELECT * from `evt_event` where status='1' and event_id IN ({$event_ids}) ORDER BY event_date");
        if ($record->num_rows > 0) {
            $k = 0;
            while ($row_event = $record->fetch_assoc()) {
                $event_id = $row_event ['event_id'];
                $event_name = $row_event ['event_name'];
                $event_date = $row_event ['event_date'];

                $result_vendor[$k]['event_id'] = $event_id;
                $result_vendor[$k]['event_name'] = $event_name;
                $result_vendor[$k]['vendors'] = $this->vendorslist_sub($event_id);
                $k++;
            }

            $this->status = true;
            $this->result['all_vendors_events'] = $result_vendor;
            $record->free();
        }
    }

    function vendorslist_sub($event_id = null, $direct = false) {
        if (is_null($event_id)) {
            $event_id = isset($_REQUEST['event_id']) ? $this->db->real_escape_string($_REQUEST['event_id']) : '';
            $direct = true;
        }
        $record_lists = $this->db->query("SELECT e.event_id,e.event_name,e.event_date,evt_vendor,evt_vendor_name,evt_vendor_email,ev.evt_vendor_phone,er.role_name FROM evt_event AS e , evt_event_vendors AS ev , evt_role AS er WHERE e.event_id=ev.ev_event_id AND ev.evt_vendor_role=er.role_id AND e.status='1' AND ev.ev_event_id='$event_id' ORDER BY e.event_date ASC,ev.evt_vendor ASC");
        if ($record_lists->num_rows > 0) {
            $j = 0;
            while ($row_vendorlist = $record_lists->fetch_assoc()) {
                $_vendor[$j]['vendor_id'] = $row_vendorlist['evt_vendor'];
                $_vendor[$j]['vendor_name'] = $row_vendorlist['evt_vendor_name'];
                $_vendor[$j]['vendor_email'] = $row_vendorlist['evt_vendor_email'];
                $_vendor[$j]['vendor_phone'] = $row_vendorlist['evt_vendor_phone'];
                $_vendor[$j]['vendor_role'] = $row_vendorlist['role_name'];
                $j++;
            }
            if ($direct):
                $this->status = true;
                $this->result = array("event_vendors" => $_vendor);
            else:
                return $_vendor;
            endif;
            $record_lists->free();
        }
    }

    function shift_time() {
        $time_id = isset($_REQUEST['time_id']) ? $this->db->real_escape_string($_REQUEST['time_id']) : '';
        $shift_min = isset($_REQUEST['shift_min']) ? $this->db->real_escape_string($_REQUEST['shift_min']) : '';
        $separator = isset($_REQUEST['separator']) ? $this->db->real_escape_string($_REQUEST['separator']) : '';
        $separator == 'plus' ? '+' : '-';

        if (!empty($time_id) && !empty($shift_min) && !empty($separator)) {
            $time_list = $this->db->query("SELECT event_id, timing_start FROM `evt_event_lists` Where timing_id = $time_id");
            if ($time_list->num_rows == 1) {
                $fetch = $time_list->fetch_assoc();
                $event_id = $fetch['event_id'];
                $timing_start = $fetch['timing_start'];

                $all_records = $this->db->query("SELECT timing_id, timing_start, event_type FROM `evt_event_lists` Where event_id = $event_id And timing_start >= '$timing_start'");
                while ($row_timelist = $all_records->fetch_assoc()) {
                    if ($row_timelist['event_type'] == 'FL') {
                        $strtotime = $separator == 'plus' ? "{$row_timelist['timing_start']} + {$shift_min} minutes" : "{$row_timelist['timing_start']} - {$shift_min} minutes";
                        $shited_time = date('H:i:s', strtotime($strtotime));
                        $this->db->query("Update `evt_event_lists` set `timing_start` = '{$shited_time}' where `timing_id` = {$row_timelist['timing_id']}");
                        $this->db->commit();
                    } else {
                        break;
                    }
                    $this->status = true;
                }
            }
        }
    }

    function pushnotification($userid = null, $message = null) {
        $userid = isset($_REQUEST['userid']) ? $this->db->real_escape_string($_REQUEST['userid']) : $userid;
        $message = isset($_REQUEST['message']) ? $this->db->real_escape_string($_REQUEST['message']) : $message;

        $device_record = $this->db->query("SELECT device_token from `evt_deviceinfos` where `user_id`= '{$userid}'");
        if ($device_record->num_rows == 1) {
            $fetch = $device_record->fetch_assoc();
            push_message($fetch['device_token'], $message);
            $this->status = true;
        }
    }

    function _get_event_by_userid($userid = null) {
        $query = "SELECT b.event_id FROM evt_event_lists b JOIN evt_event c ON c.event_id = b.event_id";
        if ($userid != NULL) {
            $query .= " WHERE b.list_role IN (SELECT a.role_id FROM evt_user a WHERE a.user_id = {$userid})";
        }
        $query .= " GROUP BY b.event_id ORDER BY c.event_date ASC ";
        $event_records = $this->db->query($query);
        $event_ids = array();
        if ($event_records->num_rows > 1) {
            while ($row_eventlist = $event_records->fetch_assoc()) {
                $event_ids[] = $row_eventlist['event_id'];
            }
        }
        return $event_ids;
    }

    function vendor_message() {
        $vendor_ids = isset($_REQUEST['vendor_ids']) ? $this->db->real_escape_string($_REQUEST['vendor_ids']) : '';
        $message = isset($_REQUEST['message']) ? $this->db->real_escape_string($_REQUEST['message']) : '';

        if (!empty($vendor_ids)) {
            $record = $this->db->query("SELECT * from `evt_event_vendors` where `evt_vendor` IN ({$vendor_ids})");
            if ($record->num_rows > 0) {
                while ($row_vendor = $record->fetch_assoc()) {
                    if ($row_vendor['evt_vendor_phone']) {
                        _send_by_sms($row_vendor['evt_vendor_phone'], $message);
                    } else {
                        _send_by_email($row_vendor['evt_vendor_email'], $message);
                    }
                }
            }
            $this->status = true;
        }
    }

    function event_reminder() {
        $remind_before = isset($_REQUEST['remind']) ? $this->db->real_escape_string($_REQUEST['remind']) : '';
        if (!empty($remind_before) && is_numeric($remind_before)) {
            $time = date('H:i', strtotime("+{$remind_before} minutes"));
            $record = $this->db->query("SELECT a.list_title, a.timing_start, (SELECT GROUP_CONCAT(b.user_id) FROM evt_user b WHERE b.role_id = a.list_role) as users FROM evt_event_lists a WHERE a.timing_start = '{$time}'");
            if ($record->num_rows > 0) {
                while ($row_event_list = $record->fetch_assoc()) {
                    $users = explode(',', $row_event_list['users']);
                    $time_start = date('h:i A', strtotime($row_event_list['timing_start']));
                    $message = "{$row_event_list['list_title']} going to start at {$time_start}";
                    foreach ($users as $userid) {
                        $this->pushnotification($userid, $message);
                    }
                }
            }
            $this->status = true;
        }
    }

    function _users_assignment($sub_event_id, $column = 'user_firstname') {
        $result = array();
        if (!empty($sub_event_id)) {
            $record = $this->db->query("SELECT a.user_id from evt_user a left join evt_event_lists b On b.list_role = a.role_id where b.timing_id = {$sub_event_id}");
            if ($record->num_rows > 0) {
                while ($fetch = $record->fetch_assoc()) {
                    $result[] = array('user_id' => $fetch['user_id'], 'name' => $this->_get_user_info($fetch['user_id'])[$column]);
                }
            }
        }
        return $result;
    }

    function _get_user_info($userid = null) {
        if (!empty($userid)) {
            $record = $this->db->query("SELECT * FROM evt_user WHERE user_id = {$userid}");
            if ($record->num_rows > 0) {
                return $record->fetch_assoc();
            }
        }
        return null;
    }

}
