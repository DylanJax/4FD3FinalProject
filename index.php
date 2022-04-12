<?php include('header.php') ?>

<body class="bodyHome">


<div class="jumbotron text-center">
  <h1 style="font-family: 'Perpetua'; font-size:72px;">
  <img src="./images/Libellus_Fd.png" style="height:70px; margin-bottom:12px;">

  Libellus</h1>
  <p>Booking made easy!</p> 
</div>

  <div class="parallax"></div>

  <div style="margin-bottom:20px;">
    <div style="height:500px;background-color:#eee;font-size:36px; text-align:center; padding:5% 15%;">
        Libellus is the central schedulding application for professional companies and home businesses. Eliminating the hassle of back and forth communcations so you can focus on work. 
        </br>
        </br>
        <h3>Click here to sign up now!</h3>
        </div>
    </div>


    <div class="container">
      <div class='row g-3'>

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

    $sql = "SELECT * FROM businesses WHERE verified != 0 LIMIT 3";
    $result = $conn->query($sql);

    while ($result->fetch_assoc())
    {
        $businesses = $result;
    }

    foreach ($businesses as $business)

    echo "
    <div class='col-12 col-md-6 col-lg-4'>
        <div class='card'>
            <img src='./images/$business[businessLogo]' class='card-img-top' alt='A Street in Europe'>
            <div class='card-body'>
                <h5 class='card-title'>$business[businessName]</h5>
                <p class='card-text'>$business[businessDescription]</p>
                <a href='/businessSingle.php?id=$business[businessId]' class='btn btn-primary'>Go to business page</a>
            </div>
        </div>
    </div>
    "
    ?>
      </div>
    </div>


<div style="margin-top:50px;" class="container">
    <div class="row">
        <div class="col-sm-4">
        <h2 style="color:blue;">Reviews</h2>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
        </div>
      </div>


  <div style="margin-top:20px;" class="row">
    <div class="col-sm-4">
      <h3>Mark Zuckerberg</h3>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star"></span>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Bill Gates</h3>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star"></span>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Elon Musk</h3>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>       
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
  </div>
</div>

<?php include('footer.php') ?>