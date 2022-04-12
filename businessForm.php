<?php include('header.php') ?>

<?php

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

    $businessName = $_POST['businessName'];
    $phoneNum = $_POST['phoneNum'];
    $businessDesc = $_POST['businessDesc'];
    $businessLogo = "placeholder.png";
    $servicesOffered = $_POST['servicesOffered'];
    $verified = 0;
    $category = $_POST['category'];
    $ownerId = $_SESSION['userid'];
    $getBusinessId = "";


    $stmt = $conn->prepare("INSERT INTO businesses(`businessName`, `phoneNumber`, `businessDescription`, `businessLogo`, `services`, `verified`,`category`, `ownerId`) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssiis",$businessName,$phoneNum,$businessDesc,$businessLogo,$servicesOffered,$verified, $category, $ownerId);
    $result = $stmt->execute();

    $sql = "SELECT * FROM businesses WHERE ownerId = '$ownerId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $info = $result->fetch_assoc();
    }
    
    $sql = "UPDATE credentials SET accountType = '$info[businessId]' WHERE userId = '$ownerId'";
    $result = $conn->query($sql);
    $_SESSION['accountType'] = $info['businessId'];
    $_SESSION['verified'] = FALSE;
    header("Location: myProfile.php");


}
?>

<body class="bodyLogin">

<div class="formContainer" style="margin:5% auto; padding:2%; width:30%; background:white;">
    <div class="formContent" style="margin:auto;">
    <h2>Start Business</h2>
    </br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group" >
                <label for="businessName">Business Name:</label>
                <input id= "businessName" type="text" name="businessName" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group"> 
                    <label for="phoneNum">Business Phone Number:</label>
                    <input id= "phoneNum" type="text" name="phoneNum" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group" >
            <label for="businessDesc">Business Description:</label>
                <textarea id= "businessDesc" type="text" name="businessDesc" placeholder="" class="form-control input-md" required="" style="height:300px;"></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="businessLogo">Business Logo:</label>
                <input id= "businessLogo" type="text" name="businessLogo" placeholder="" class="form-control input-md" required="">
            </div> -->
            <div class="form-group">
                <label for="servicesOffered">Services Offered (separated by commas):</label>
                <input id= "servicesOffered" type="text" name="servicesOffered" placeholder="" class="form-control input-md" required="">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id= "category" type="text" name="category" placeholder="" class="form-control input-md" required="">
                    <option value="1">Beauty & Wellness</option>
                    <option value="2">Educational</option>
                    <option value="3">Personal Meetings</option>
                    <option value="4">Professional Services</option>
                    <option value="5">Sport & Fitness</option>
                    <option value="6">Medical & Health Services</option>
                </select>
            </div>
            </br>
            <div class="form-group">
                <button id="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            <div>
                <p style="text-align: center;"></p>
            </div>

    </form>
    </div>
</div>
</body>

<?php include('footer.php') ?>