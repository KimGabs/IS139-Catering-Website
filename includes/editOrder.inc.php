<?php

if(isset($_POST['editOrder'])){
    
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    $orderId = $_POST['orderId'];
    $cxName = $_POST['cxName'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $contactNo = $_POST['contactNo'];
    $eventLocation = $_POST['eventLocation'];
    $request = strtolower($_POST['request']);

    $eventTime = date("H:i", strtotime($eventTime));
    updateOrderInfo($conn, $orderId, $cxName, $eventDate, $eventTime, $contactNo, $eventLocation, $request);
}