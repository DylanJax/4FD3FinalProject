<?php include('header.php'); 
    include 'bookingCalendar.php';

    
                //phpMailer Files
                require 'references/PHPMailer.php';
                require 'references/SMTP.php';
                require 'references/Exception.php';

                //define name spaces 
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;
?>
<?php

$servername = "localhost";
$username = "root";
$password = "usbw";
$database_in_use = "test";
$flag = 0;
$bookingMsg = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database_in_use);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $businessId = $_COOKIE['businessId'];


    if(!isset($_SESSION["userid"]))
    {
        $bookingMsg = "Please login to book an appointment.";
        $flag = 1;
    }

    if ($flag != 1) {

        $sql = "SELECT email FROM credentials WHERE userId = '$_SESSION[userid]'";
        $result = $conn->query($sql);
        while ($result->fetch_assoc())
        {
            $emailRecipient = $result;
        }
        foreach ($emailRecipient as $Recipient)
        {
            $recipientEmail = $Recipient['email'];

        }

        $sql = "UPDATE availabledates SET customerId = '$_SESSION[userid]', service = '$_POST[service]'  WHERE bookingId = $_COOKIE[bookingId]";
        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {

            $sql = "SELECT * FROM availabledates WHERE bookingId = $_COOKIE[bookingId]";
            $result = $conn->query($sql);
            while ($result->fetch_assoc())
            {
                $appointmentDetails = $result;
            }
            foreach ($appointmentDetails as $details)
            {
                $bookedBusinessId = $details['businessId'];
                $appointmentDate = $details['date'];
                $timeSlot = $details['timeSlot'];
                $service = $details['service'];
            }

            $sql = "SELECT businessName FROM businesses WHERE businessId = $bookedBusinessId";
            $result = $conn->query($sql);
            while ($result->fetch_assoc())
            {
                $businessName = $result;
            }
            foreach ($businessName as $name)
            {
                $nameBusiness = $name['businessName'];
            }



                //instance phpmailer
                $mail = new PHPMailer();
                //set mailer, use SMTP
                $mail->isSMTP();
                //smtp host
                $mail->Host = "smtp.gmail.com";
                //smtp authentication
                $mail->SMTPAuth = "true";
                //set encryption type (tls/ssl)
                $mail->SMTPSecure = "tls";
                //set port to connet to SMTP (ssl=465, tls=587)
                $mail->Port = "587";

                //login credentials
                $mail->Username = "teamlibellus@gmail.com";
                $mail->Password = "AdminLibellus123";



                //Email details
                $mail->Subject = "$nameBusiness - Appointment Scheduled";
                $mail->setFrom("teamlibellus@gmail.com");
                $mail->Body = "Your appointment with $nameBusiness for $service has been booked for $timeSlot on $appointmentDate!";

                //Recipients 
                $mail->addAddress($recipientEmail);

                //Email sent status
                if ($mail->Send() ) {
                $bookingMsg = "Appointment booked successfully.";
                } else {
                $bookingMsg = "ERROR: Booking failed.";
                }

            }


           else {
            $bookingMsg = "Error booking appointment: " . $conn->error;
          }


          
    }
}

else {
    $businessId = $_GET['id'];

}



$sql = "SELECT * FROM businesses WHERE businessId = $businessId";
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


$sql = "SELECT * FROM availabledates WHERE businessId = $businessId AND customerId IS NULL";
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
<div class="col-lg-4" style="display:none" id="timeSlots">
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="slot">Timeslot:</label>
            <p id="timeSlot"> </p>

            <label for="slot">Select a service:</label>
            <select id="service" name="service">
                <?php
                    foreach ($services as $service)
                    {
                        echo "<option value='$service'>$service</option>";

                    }
                ?>
            </select>
            <button class="btn btn-primary" id="submitBtn">Book appointment</button>
        </form>
    </div>
</div>
<div style="position: absolute; left: 60%;">
        <p><?php echo "$bookingMsg"?></p>
</div>


<script>


    $(".timeSlot").click(function(){
        $("#timeSlots").css("display","inline-block");
        $("#timeSlot").html($("#" + this.id).text());
        $.post('cookieSet.php', {bookingId: this.id,businessId: <?php echo $businessId?> , function(){    
        }});
    });


</script>

<?php include('footer.php') ?>