<?php
// $servername = "localhost";
// $username = "root";
// $password = "usbw";
// $database_in_use = "test";

setcookie("bookingId", $_POST['bookingId'], time() + (86400 * 30), "/"); // 86400 = 1 day
setcookie("businessId", $_POST['businessId'], time() + (86400 * 30), "/"); // 86400 = 1 day


// // Create connection
// $conn = new mysqli($servername, $username, $password, $database_in_use);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $businessId = $_POST['businessId'];
// $date = $_POST['date'];

// $sql = "SELECT * FROM availabledates WHERE businessId = $businessId AND customerId IS NULL";
// $result = $conn->query($sql);

// while ($result->fetch_assoc())
// {
//     $business = $result;
// }

// foreach ($business as $bus){
//      echo $date;

//  }


?>
