<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR."functions.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>login</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script type="text/javascript" src="js/jquery.min.js">></script>
  <script type="text/javascript" src="js/qr.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div id="main">
  <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Programs</a></li>
        <li><a href="#">Downloads</a></li>
        <li><a href="#">Feedback</a></li>
        <li><a href="#">Contact</a></li>
      
    </ul>
  </nav>
</div>

<div class="sign-up">
  <div class="sig">Signup: </div>
  <form action="php/functions.php" method="post">
    <div class="container">
      <?php if(isset($_SESSION['error'])) { echo $_SESSION['error']."<br><br>"; }?>
      <label><b>First name</b></label>
      <input type="text" placeholder="Firstname" name="fname" required>

      <label><b>Last name</b></label>
      <input type="text" placeholder="Lastname" name="lname" required>

      <label><b>Mobile:</b></label>
      <input type="number" placeholder="Enter Mobile Number" name="mobile" required>

      <label><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="reg_username" required>

      <div class="clearfix">
        <input type="hidden" name="action" value="register">
        <a class="resetbtn">Reset</a>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>
<div class="login-form">
  <div class="log">Login: </div>
  <div class="container">
    <label><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="username" required>
    <!-- <button type="submit">Login</button> -->
  </div>
  <div class="qrcode">
  <p></p>
  <img src="">
  </div>
</div>
<script type="text/javascript">
count=0;
  $('input[name=reg_username]').keydown(function() {
    var interval = setInterval(function() {
      $.ajax({
        url: "php/functions.php",
        data: {action:'getsession'},
        success: function(resp){
          console.log("signupresp",resp);
          resp = JSON.parse(resp);
          var username = resp["temp_username"];
          var uniquekey = resp["temp_uniquekey"];
          var reg_username = $('input[name=reg_username]').val();
          count++;
          if(username == "" || uniquekey == "" ||username != reg_username) {
            $('.signupbtn').prop('disabled', true).css("opacity","0.5");
          }else{
            clearInterval(interval);
            $('.signupbtn').prop('disabled', false).css("opacity","1");
          }
          if(count > 500) {
            clearInterval(interval);
            window.location.reload();
            count = 0;
          }
        }
      });
    },1000);
    count = 0;
  });
var currentRequest = null;
  $('input[name=username]').on('keydown', function(e) {
     var search = $(this).val();
    if(search.length >= 3 ) {
      var interval = setInterval(function() {    
        currentRequest = $.ajax({
          url: "php/functions.php",
          data: {action:'getsession'},
          beforeSend : function()    {     
              console.log("currentRequest",currentRequest);      
              if(currentRequest != null) {
                  currentRequest.abort();
              }
          },
          success: function(resp){
            console.log(resp,resp.length);
            if(resp.length > 2) {
              resp = JSON.parse(resp);
              var username = resp["username"];
              var uniquekey = resp["uniquekey"];
              var reg_username = $('input[name=username]').val();
              $(this).off();
              count++;
              if(username != "" && uniquekey != "" && username == reg_username) {
                clearInterval(interval);
                location.href="php/userdashboard.php";  
              }else {
                $.ajax({
                  url: "php/logout.php",
                  method: "post",
                  data: {unsetsession:'1'},
                  success: function(data) {
                    console.log(data);
                    clearInterval(interval);
                    alert("Failed to login.");
                    return false;
                    window.location.reload();
                  }
                });
              }
            }
            if(count > 500) {
              clearInterval(interval);
              window.location.reload();
              count = 0;
            }
          }
        });
      },1000);
      count = 0;
    }
  });
</script>
</body>
</html>
<?php 
unset($_SESSION['Error_meesage']);
unset($_SESSION['error']);
?>