<?php
date_default_timezone_set("Asia/Kolkata"); 

$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
   $hostname = "localhost";  
   $username = "root";
   $password = "";   
   $dbname   = "event_org";      
} else {
   $hostname = "localhost"; 
   $username = "rajencba_prakash";
   $password = "&Fzk*^A1rd%T";  
   $dbname   = "rajencba_event_org"; 
}

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");

$selected = mysql_select_db($dbname,$dbhandle)
or die("Could not select examples");
?>