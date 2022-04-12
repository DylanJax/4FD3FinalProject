<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script type="text/javascript" src="/references/timepicker/jquery.timepicker.min.js"></script>
  <link rel="stylesheet" href="/references/timepicker/jquery.timepicker.css">




  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>

<?php
    session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img src="./images/Libellus_Fd.png" style="height:40px;">
  <a class="navbar-brand" href="#">Libellus</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="businesses.php">Businesses</a>
      </li>      
      <li class="nav-item active">
        <a class="nav-link" href="aboutus.php">About Us</a>
      </li>     
    <li class="nav-item active">
        <a class="nav-link" href="contactus.php">Contact Us</a>
    </li>
</ul>
<ul class="navbar-nav me-auto">
  <li class="nav-item active">
  <?php
  if (isset($_SESSION['accountType']))
    if ($_SESSION['accountType'] != NULL ) {
      echo" <a class='nav-link' href='myBusiness.php'>My Business</a>";
    }

  ?>
  </li>
<li class="nav-item active">
<?php 


  if ($_SESSION)
  {
    echo" <a class='nav-link' href='myProfile.php'>My Profile</a>";

  }
?>
    </li>
<li class="nav-item active">
    <?php 


        if ($_SESSION)
        {
            echo" <a class='nav-link' href='logout.php'>Logout</a>";
        }

        else
        {
            echo" <a class='nav-link' href='login.php'>Login</a>";
        }
    ?>
      </li>
</ul>

  </div>
</nav>