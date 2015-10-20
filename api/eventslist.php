<?php

include_once 'includes/config.php';
include_once 'includes/functions.php';
$status = false;
$result = array();

$select_events = "SELECT * from `evt_event` where status='1' ORDER BY event_date ";
$result_events = mysql_query($select_events);
$count = mysql_num_rows($result_events);

if ($count >0) {
    while ($row_event = mysql_fetch_assoc($result_events)) {
        $event_id = $row_event ['event_id'];
        $event_name = $row_event ['event_name'];
        $event_date = $row_event ['event_date'];
        
        $result_event[$event_id]['id']   = $event_id;
        $result_event[$event_id]['name'] = $event_name;
        $result_event[$event_id]['date'] = $event_date;
        
        $select_event_lists = "SELECT el.*,er.role_name FROM `evt_event_lists` AS el, evt_role AS er WHERE el.list_role=er.role_id AND el.event_id='$event_id' AND er.status='1' ORDER BY el.timing_start ASC";
        $result_event_lists = mysql_query($select_event_lists);
        $count_lists = mysql_num_rows($result_event_lists);
        if ($count_lists >0) {             
             while ($row_eventlist = mysql_fetch_assoc($result_event_lists)) {
                 $timing_id  = $row_eventlist['timing_id'];
                 $event_type = ($row_eventlist['event_type']=='FX')? 'Fixed':'Flexible';
                 $_event[$timing_id]['list_title']   = $row_eventlist['list_title'];
                 $_event[$timing_id]['role_name']    = $row_eventlist['role_name'];
                 $_event[$timing_id]['event_type']   = $event_type;
                 $_event[$timing_id]['timing_start'] = date('h:i A', strtotime($row_eventlist['timing_start']));
                 $_event[$timing_id]['timing_end']   = date('h:i A', strtotime($row_eventlist['timing_end']));
             }     
             $result_event[$event_id]['events'] = $_event;
        }
        
        echo "<pre>";
        print_r($result_event);       
        exit;
    }
      
}

$response = array_merge(array('status' => $status), array_filter($result));
echo json_encode($response, true);