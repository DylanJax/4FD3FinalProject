<?php include('header.php') ?>
<body class="bodyBusinesses">


<div class="col-lg-2" style="display:inline-block"></div>
<div class="col-lg-8" style="display:inline-block">
<h2 style="font-family: 'Perpetua'; text-align:center; padding-top:50px; padding-bottom:20px;">Explore Businesses</h2>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 20px; border-radius:15px;">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <li id="0" class="nav-item categoryItem">
                <a class="nav-link">All</a>
            </li>
            <li id="1" class="nav-item categoryItem">
                <a class="nav-link">Beauty & Wellness</a>
            </li>  
            <li id="2"class="nav-item categoryItem">
                <a class="nav-link">Educational</a>
            </li>  
            <li id="3" class="nav-item categoryItem">
                <a class="nav-link">Personal Meetings</a>
            </li>     
            <li id="4" class="nav-item categoryItem">
                <a class="nav-link">Professional Services</a>
            </li>
            <li id="5" class="nav-item categoryItem">
                <a class="nav-link">Sport & Fitness</a>
            </li>
            <li id="6" class="nav-item categoryItem">
                <a class="nav-link">Medical & Health Services</a>
            </li>

        </ul>
    </div>
    </nav>

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

        $businesses = array();

        if (isset($_GET["id"]))
        {
            if ($_GET["id"] == 0)
            {
                $sql = "SELECT * FROM businesses WHERE verified != 0";
                $result = $conn->query($sql);
            }
            
            else{
                $sql = "SELECT * FROM businesses WHERE category = $_GET[id] AND  verified != 0";
                $result = $conn->query($sql);   
            }    
        }    
        else{
            $sql = "SELECT * FROM businesses WHERE  verified != 0";
            $result = $conn->query($sql);

    }

    while ($result->fetch_assoc())
    {
        $businesses = $result;
    }

    foreach ($businesses as $business)
    {
        echo "
            <div class='card'>
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
            </div>
            </br>
        ";
    }

    ?>
</div>
<div class="col-lg-2" style="display:inline-block"></div>

<script>
    $(".categoryItem").click(function(){
        window.location.href = "businesses.php?id=" + this.id;
    })
</script>


<?php include('footer.php') ?>