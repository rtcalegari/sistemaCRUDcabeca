<?php
include_once __DIR__ . '/conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
} else {

    //ver em https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    header("HTTP/1.1 401 Not Allowed");
}