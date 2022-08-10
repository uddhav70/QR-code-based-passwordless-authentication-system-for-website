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
</head>
<body>
<div class="sign-up">
<p><b><h3>Signup: </h3></b></p><br>
  <form action="php/functions.php" method="post">
    <div class="container">
      <?php if(isset($_SESSION['error'])) { echo $_SESSION['error']."<br><br>"; }?>
      <label><b>First name</b></label>
      <input type="text" placeholder="Firstname" name="fname" required>

      <label><b>Last name</b></label>
      <input type="text" placeholder="Lastname" name="lname" required>

      <label><b>Email id:</b></label>
      <input type="email" placeholder="Enter Email" name="email" required>

      <label><b>Username</b></label>
      <input type="password" placeholder="Enter username" name="reg_username" required>

      <div class="clearfix">
        <input type="hidden" name="action" value="register">
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>
<div class="login-form">
<p><h3><b>Login: </b></h3></p><br>
  <div class="container">
    <label><b>Username</b></label>
    <input type="password" placeholder="Enter Username" name="username" required>
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