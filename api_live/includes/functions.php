<?php

function __autoload($className) {
    $filename = $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}

function encrypt_pass($value) {
    return hash("sha512", $value);
}

function push_message($deviceToken, $message) {
    // Put your device token here (without spaces):
    //$deviceToken = '0f744707bebcf74f9b7c25d48e3358945f6aa01da5ddb387462c7eaf61bbad78';
    // Put your private key's passphrase here:
    $passphrase = 'pushchat';

    // Put your alert message here:
    //    $message = 'My first push notification!';
    ////////////////////////////////////////////////////////////////////////////////

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

    // Create the payload body
    $body['aps'] = array(
        'alert' => $message,
        'sound' => 'default'
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result)
        $resp = 'Message not delivered' . PHP_EOL;
    else
        $resp = 'Message successfully delivered' . PHP_EOL;

    // Close the connection to the server
    fclose($fp);
    return $resp;
}

function _send_by_sms($phone, $message) {
    return true;
}

function _send_by_email($email, $content) {

    $message = '<html><body>';
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
    $message .= "<tr style='background: #eee;'><td><strong>Message:</strong> </td><td>" . $content . "</td></tr>";
    $message .= "</table>";
    $message .= "</body></html>";
    
    $subject = 'Contact Message';
    $headers = "From: Support <no-reply@demo.ltd>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    return mail($email, $subject, $message, $headers);
}
