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

    $userId = $_POST['userId'];
    $pwrd = $_POST['pwrd'];

    $stmt = $conn->prepare("SELECT userId, pwrd, accountType FROM credentials WHERE userId = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($username, $pw, $accountType);

    
    if ($stmt->num_rows == 1){
        
        $stmt->fetch();
        if (password_verify($pwrd, $pw)){
            $_SESSION['userid'] = $userId;
            $_SESSION['accountType'] = $accountType;
            header("Location: index.php");
        }
        
        else{
            echo "Incorrect username or password.";
            $_SESSION = [];
            session_destroy();
    }

    }

    else{
        echo "Incorrect username or password.";
        $_SESSION = [];
        session_destroy();
    }

}


?>

<body class="bodyLogin">

<div class="formContainer" style="margin:5% auto; padding:2%; width:30%; background:white;">
    <div class="formContent" style="margin:auto; text-align:center;">
    <h2>Login</h2>
    </br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group"  style="width:50%; margin:auto">
                <input id= "userId" type="text" name="userId" placeholder="Username" class="form-control input-md" required="">
            </div>
            </br>
            <div class="form-group" style="width:50%; margin:auto"> 
                    <input id= "pwrd" type="password" name="pwrd" placeholder="Password" class="form-control input-md" required="">
            </div>
            </br>
            <div class="form-group">
                <label for="submit"></label>
                <button id="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
    </form>

    <p>Don't have an account?</br>
    Create one <a href="createAccount.php">here.</a></p>

    </div>
</div>




<?php include('footer.php') ?>