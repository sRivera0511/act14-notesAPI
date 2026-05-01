<?php
$request = $_SERVER['REQUEST_URI'];

if (strpos($request, 'notes') !== false) {
    include 'notes.php';
}
?>