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
        $username = isset($_REQUEST['username']) ? mysqli_real_escape_string($this->db, $_REQUEST['username']) : '';
        $password = isset($_REQUEST['password']) ? mysqli_real_escape_string($this->db, $_REQUEST['password']) : '';

        if (!empty($username) && !empty($password)) {
            $password = encrypt_pass($password);
            $record = $this->db->query("SELECT * from `evt_user` where (username ='{$username}' OR `user_email`= '{$username}') and `password_hash`= '{$password}'");
            if ($record->num_rows == 1) {
                $row_users = $record->fetch_assoc();
                $firstname = $row_users['user_firstname'];
                $user_id = $row_users['user_id'];
                $role = $row_users['role_id'];

                $this->status = true;

                $this->result['msg'] = "Successfully logged in";
                $this->result['user_firstname'] = $firstname;
                $this->result['user_id'] = $user_id;
                $this->result['role'] = $role;
            }
            $record->free();
        }
    }

    function eventlist() {
        $userid = isset($_REQUEST['userid']) ? mysqli_real_escape_string($this->db, $_REQUEST['userid']) : '';
        $record = $this->db->query("SELECT * from `evt_event` where status='1' and created_by='$userid' ORDER BY event_date");

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
            $event_id = isset($_REQUEST['event_id']) ? mysqli_real_escape_string($this->db, $_REQUEST['event_id']) : '';
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
                $j++;
            }
            if ($direct):
                $this->status = true;
                $this->result = array("event_cats"=>$_event);
            else:
                return $_event;
            endif;
            $record_list->free();
        }
    }

    function vendorslist() {
        $userid = isset($_REQUEST['userid']) ? mysqli_real_escape_string($this->db, $_REQUEST['userid']) : '';
        $get_query = ($userid > 0 && $userid != '') ? " and created_by='$userid' " : "";

        $record = $this->db->query("SELECT * from `evt_event` where status='1' $get_query ORDER BY event_date");
        if ($record->num_rows > 0) {
            $k = 0;
            while ($row_event = $record->fetch_assoc()) {
                $event_id = $row_event ['event_id'];
                $event_name = $row_event ['event_name'];
                $event_date = $row_event ['event_date'];

                $result_vendor[$k]['event_id'] = $event_id;
                $result_vendor[$k]['event_name'] = $event_name;

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
                    $result_vendor[$k]['vendors'] = $_vendor;
                    $record_lists->free();
                }
                $k++;
            }

            $this->status = true;
            $this->result['all_vendors_events'] = $result_vendor;
            $record->free();
        }
    }

}
