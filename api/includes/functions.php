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
