<?php include('header.php'); 
    include 'bookingCalendar.php';
?>

<?php

$servername = "localhost";
$username = "root";
$password = "usbw";
$database_in_use = "test";
$businessId = $_SESSION['accountType'];
$date = "";
$startTime = "";
$endTime = "";
$timeslot = "";
$errMsg = "";
$errFlag = 0;


// Create connection
$conn = new mysqli($servername, $username, $password, $database_in_use);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['addTimeslot']))
    {

    $currentDate= date("Y-m-d");
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    if ($currentDate > $date)
    {
        $errMsg = $errMsg . "Date cannot be in the past.</br>";
        $errFlag = 1;
    }

    if ($startTime > $endTime)
    {
       $errMsg = $errMsg . "End time must be later than start time.</br>";
       $errFlag = 1;
    }
    
    if ($errFlag == 0)
    {
        $timeslot = $startTime . '-' . $endTime;
        $sql = "INSERT INTO availabledates(`businessId`,`date`,`timeSlot`) VALUES ('$businessId', '$date', '$timeslot')";
        $result = $conn->query($sql);
        $date = "";
        $startTime = "";
        $endTime = "";
        $timeslot = "";
    }
    }

    if (isset($_POST['deleteTimeslot']))
    {
        $sql = "DELETE FROM availabledates WHERE bookingId = $_POST[bookingId]";
        $result = $conn->query($sql);
    }


    if (isset($_POST['updateTimeslot']))
    {
        $updateTimeSlot = $_POST['updateStartTime'] . '-' . $_POST['updateEndTime'];
        $updateDate = $_POST['updateDate'];
        $updateBookingId = $_POST['bookingId'];

        $sql = "UPDATE availabledates SET date = '$updateDate', timeSlot = '$updateTimeSlot' WHERE bookingId = $updateBookingId";
        $result = $conn->query($sql);
    }
}




$sql = "SELECT * FROM businesses WHERE businessId = $_SESSION[accountType]";
$result = $conn->query($sql);
$business = $result->fetch_assoc();
$services = explode(", ", $business['services']);


echo "<div class='card'>
        <div class='card-body'>
            <div class='col-lg-4 col-md-4' style='display:inline-block;'>
                <img src='./images/$business[businessLogo]' class='card-img-top' alt='A Street in Europe'>
            </div>
            <div class='col-lg-7 col-md-7' style='display:inline-block;'>
                <h5 class='card-title'>$business[businessName]</h5>
                <p class='card-text'>$business[businessDescription]</p>
                <a href='/businessSingle.php?id=$business[businessId]' class='btn btn-primary businessBtn'>Go to business page</a>
            </div>
        </div>
        </br>

</div>";

date_default_timezone_set('EST');
$calendar = new Calendar(date("Y-m-d")); 



$sql = "SELECT * FROM availabledates WHERE businessId = $_SESSION[accountType] AND customerId IS NULL";
$result = $conn->query($sql);

while ($result->fetch_assoc())
{
    if ($result->num_rows > 0)
    {
    foreach ($result as $bookdle){
            $calendar->addTimeSlot( $bookdle['bookingId'], $bookdle['timeSlot'], $bookdle['date'], 1, 'green');

        }
    }
}

?>


<body class="bodyBusiness">



<?=$calendar?>
<div class="col-lg-4" style="display:inline-block" id="myTimeSlots">
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="slot">Add A Timeslot:</label>
            </br>
            <label for="date">Date:</label>
            <input required type="text" id="date" class="datepicker" name="date">
            </br>
            <label for="startTime">Start Time:</label>
            <input required type="text" class="timepicker" id="startTime" name="startTime">
            </br>
            <label for="endTime">End Time:</label>
            <input required type="text" class="timepicker" id="endTime" name="endTime">
            </br>

            <button class="btn btn-primary" name="addTimeslot" id="submitBtn">Add timeslot</button>
        </form>
    </div>
    </br>
    </br>
    </br>
    <div style="display:none" id="timeSlots2">
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="slot">Selected Timeslot:</label>
                <p id="timeSlotTime"> </p>
                <label for="updateDate">Date:</label>
                <input  type="text" id="updateDate" class="datepicker" name="updateDate">
                </br>
                <label for="startTime">Start Time:</label>
                <input  type="text" class="timepicker" id="updateStartTime" name="updateStartTime">
                </br>
                <label for="endTime">End Time:</label>
                <input  type="text" class="timepicker" id="updateEndTime" name="updateEndTime">
                </br>
                <input id="bookingId" name="bookingId" type="text" style="display:none">
                <button class="btn btn-danger" name="deleteTimeslot" id="deleteBtn">Delete appointment</button>
                <button class="btn btn-primary" name="updateTimeslot" id="updateBtn">Update appointment</button>

            </form>
        </div>
    </div>
    <p style="float:left" class="error">
        <?php
            echo $errMsg;
        ?>
    </p>
</div>
<div id="result"></div>




<script>

    $(document).ready(function(){

        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('.timepicker').timepicker();



    });


    $(".event").click(function(){
        $("#timeSlots2").css("display","inline-block");
        $("#timeSlotTime").html($("#" + this.id).text());
        $("#bookingId").val(this.id);
    });




</script>

<?php include('footer.php') ?>