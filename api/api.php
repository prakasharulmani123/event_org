<?php
include_once 'includes/functions.php';

$mode = isset($_REQUEST['mode']) ? mysql_real_escape_string($_REQUEST['mode']) : '';

try {
    $webService = new WebServicesAPI();
    $webService->$mode();
    $response = array_merge(array('status' => $webService->status), array_filter($webService->result));
    echo json_encode($response, true);

} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
die();