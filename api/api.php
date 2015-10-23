<?php
error_reporting(E_ALL ^E_WARNING ^E_NOTICE );
include_once 'includes/functions.php';

$mode = isset($_REQUEST['mode']) ? trim($_REQUEST['mode']) : '';

try {
    $webService = new WebServicesAPI();
    $webService->$mode();
    $response = array_merge(array('status' => $webService->status), array_filter($webService->result));
    if($_REQUEST['debug'] == 'true'):
        echo "<pre>"; print_r($response); exit;
    endif;
    echo json_encode($response, true);

} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
die();