<?php

namespace Router\Response;


function redirect($url)
{
    header('Location: '.$url);
    exit;
}


function json(array $data, $status_code = 200)
{
    header('HTTP/1.0 '.$status_code);
    header('Content-Type: application/json');

    echo json_encode($data);
    exit;
}