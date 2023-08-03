<?php

require_once 'database.inc.php';

$sql = "SELECT *
FROM orders;";
$result = $conn->query($sql);

$dataArray = array();
while ($row = mysqli_fetch_assoc($result)) {
    echo "<script>console.log('Iter')</script>";
    $dateParts = explode("-", $row['eventDate']);
    // Get the individual parts
    $year = $dateParts[0];
    $month = $dateParts[1];
    $day = $dateParts[2];
    $dateTime = DateTime::createFromFormat('H:i', $row['eventTime']);
    $formattedTime = $dateTime->format('g:i A');

    if($row['orderStatus'] == "cancelled"){
        $cancelled = true;
    }else{
        $cancelled = false;
    }

    $data = array(
        'orderId' => (int)$row['orderId'],
        'cxName' => $row['cxName'],
        'contact' => $row['contactNo'],
        'year' => (int)$year,
        'month' => (int)$month,
        'day' => (int)$day,
        'time' => $formattedTime,
        'orderStatus' => $row['orderStatus'],
        'eventLocation' => $row['eventLocation'],
        'request' => $row['request']
    );

    $dataArray['events'][] = $data;
}


$jsonEvent = json_encode($dataArray);