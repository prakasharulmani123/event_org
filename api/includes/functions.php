<?php

    function encrypt_pass($value) {
        return hash("sha512", $value);
    }