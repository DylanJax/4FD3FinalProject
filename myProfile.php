<?php include('header.php') ?>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "usbw";
    $database_in_use = "test";

    $conn = new mysqli($servername, $username, $password, $database_in_use);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM credentials WHERE userId = '$_SESSION[userid]'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $info = $result->fetch_assoc();
    }

    $sql = "SELECT * FROM businesses WHERE businessId = '$_SESSION[accountType]'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $businessInfo = $result->fetch_assoc();
    }
?>
<div class="card" id="personalCard" style="text-align:center">
        <div>
            <h2>Personal Info</h2>
            <div>
                <h6>Full Name:</h6> 
                <p><?php echo $info['fullName']?></p>
            </div>
            <div>
                <h6>Username:</h6>
                <p><?php echo $info['userId']?></p>
            </div>
            <div>
                <h6>Email:</h6>
                <p><?php echo $info['email']?></p>
            </div>
            <div>
                <h6>Phone Number:</h6>
                <p><?php echo $info['phone']?></p>
            </div>
        </div>
        <?php 
        if ($_SESSION["accountType"] == NULL)
        {
            echo"<div><h2><a href='businessForm.php'>Start My Business</a></h2></div>";
        }
        ?>
</div>
<?php
      if (isset($_SESSION['accountType']))
      if ($_SESSION['accountType'] != NULL ) {
        echo"<div class='card' id='personalCard' style='text-align:center'>";

        if (isset($_SESSION["verified"]))
        {
            if ($_SESSION["verified"] == FALSE)
            {
                echo"<div><p style='color:green'>You will recieve an email once your business is verified by our team.</p></div>";

            }
        }
        echo "
            <div>
                <h2>Business Info</h2>
                <div>
                    <h6>Business Name:</h6> 
                    <p>$businessInfo[businessName]</p>
                </div>
                <div>
                    <h6>Business Description</h6>
                    <p>$businessInfo[businessDescription]</p>
                </div>
                <div>
                    <h6>Services:</h6>
                    <p>$businessInfo[services]</p>
                </div>
                <div>
                    <h6>Phone Number:</h6>
                    <p>$businessInfo[phoneNumber]</p>
                </div>
            </div>
         </div>";
      }

?>


<?php include('footer.php') ?>