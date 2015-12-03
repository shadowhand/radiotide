<?php

namespace Shadowhand\RadioTide;

function get_server_url()
{
    $protocol = 'http';

    if (is_ssl_active()) {
        $protocol .= 's';
    }

    return $protocol . '://' . $_SERVER['HTTP_HOST'];
}

function is_ssl_active()
{
    return !empty($_SERVER['SSL'])
        && strtolower($_SERVER['SSL']) === 'on';
}
