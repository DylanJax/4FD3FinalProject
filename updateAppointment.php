<?php

$servername = "localhost";
$username = "root";
$password = "usbw";
$database_in_use = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database_in_use);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookingId = $_POST['bookingId'];

$sql = "SELECT * FROM availabledates WHERE bookingId = $bookingId";
$result = $conn->query($sql);

while ($result->fetch_assoc())
{
    $business = $result;
}

foreach ($business as $bus){
     echo $date;

 }
?>