<?php include('header.php');
?>

<?php

$nameErr = "";
$userErr = "";
$pwrdErr = "";
$confPwrdErr = "";
$matchErr = "";
$emailErr = "";
$phoneNumErr = "";
$successMessage = "";
$errFlag = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    
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

    $fullName = $_POST['fullName'];
    $userId = $_POST['userId'];
    $pwrd = $_POST['pwrd'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    // $accountType = $_POST['accountType'];
    

    //Validation----------------------------------------------
    //Full Name validation
    if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["fullName"])) {
          $nameErr = "Only letters and white space allowed";
          $errFlag = 1;
    }

    //Username validation
    if (!preg_match("/^[a-zA-Z-0-9]*$/",$_POST["userId"])) {
        $userErr = "Only letters and numbers allowed";
        $errFlag = 1;
      }
    
    $sql = "SELECT userId FROM credentials WHERE userId = '$userId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $userErr = "That username is already taken";
        $errFlag = 1;
    }

    //Password validation
    if ($_POST["pwrd"] != $_POST["confirmPwrd"]){
        $matchErr = "Passwords must match";
        $errFlag = 1;
    }

    //E-mail validation
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $errFlag = 1;
      }
    
    $sql = "SELECT email FROM credentials WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $emailErr = "That email is already in use";
        $errFlag = 1;
    }

    //Phone number validation
    if (!preg_match("/^[0-9]{10}$/",$_POST["phoneNumber"])) {
        $phoneNumErr = "Invalid phone number";
        $errFlag = 1;
      }
    
    $sql =  "SELECT phone FROM credentials WHERE phone = '$phoneNumber'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $phoneNumErr = "That phone number is already in use";
        $errFlag = 1;
    }

    if ($errFlag == 0)
    {
    $hashed_password = password_hash($pwrd, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO credentials(`userId`, `pwrd`, `fullName`, `phone`, `email`) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$userId,$hashed_password,$fullName,$phoneNumber,$email);
    $result = $stmt->execute();
    // $sql = "INSERT INTO credentials(`userId`, `pwrd`, `fullName`, `phone`, `email`, `accountType`) VALUES ('$userId','$pwrd','$fullName','$phoneNumber','$email','$accountType')";
    // $result = $conn->query($sql);
    $successMessage ="Account created successfully! </br> Click <a href='login.php'>here</a> to login.";
    }
    
}


?>

<body class="bodyLogin">

<div class="formContainer" style="margin:5% auto; padding:2%; width:30%; background:white;">
    <div class="formContent" style="margin:auto;">
    <h2>Create Account</h2>
    </br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group" >
                <label for="fullName">Full Name</label>
                <span class="error"> <?php echo $nameErr;?></span>
                <input id= "fullName" type="text" name="fullName" placeholder="" class="form-control input-md" required="">

            </div>
            <div class="form-group"> 
                    <label for="userId">Username</label>
                    <span class="error"> <?php echo $userErr;?></span>
                    <input id= "userId" type="text" name="userId" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group" >
            <label for="pwrd">Password</label>
                <span class="error"> <?php echo $pwrdErr;?></span>
                <input id= "pwrd" type="password" name="pwrd" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group">
                <label for="confirmPwrd">Confirm Password</label>
                <span class="error"> <?php echo $confPwrdErr;?></span>
                <span class="error"> <?php echo $matchErr;?></span>
                <input id= "confirmPwrd" type="password" name="confirmPwrd" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <span class="error"> <?php echo $emailErr;?></span>
                <input id= "email" type="text" name="email" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <span class="error"> <?php echo $phoneNumErr;?></span>
                <input id= "phoneNumber" type="text" name="phoneNumber" placeholder="" class="form-control input-md" required="">
            </div>
            <!-- <label for="accountType">Account Type</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accountType" id="customer" value="1" checked>
                <label class="form-check-label" for="customer">Customer</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="accountType" id="business" value="0">
                <label class="form-check-label" for="business">Business</label>
            </div> -->
            </br>
            <div class="form-group">
                <button id="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            <div>
                <p style="text-align: center;"><?php echo "$successMessage"?></p>
            </div>

    </form>
    </div>
</div>




<?php include('footer.php') ?>