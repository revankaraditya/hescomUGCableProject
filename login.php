<?php ini_set("display_errors", 1);
	include_once('login_authenticate.php');
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Location" content="index.php">
  <title>Hescom | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/css/full-slider.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <link type="text/css" rel="stylesheet" href="bootstrap/css/animate.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
</head>

<body class=" login-page" style="background-color:#1f1f1f;" >
    <!--div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('images/test1.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('images/test2.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('images/slide3.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
</div-->
        <!--div class=" item">
        <div class="fill img-fluid" style="background-image:url('images/test2.jpg');"></div>
        <div class="carousel-caption">
                </div>
        </div>
    </div-->	
		<div class="login-box" style="background-image: radial-gradient(black, #1f1f1f);">
			  <div class="login-logo">
				<a href="#"><b style="font-family: Audiowide, sans-serif;color:gold;text-shadow: 8px 8px 8px #ababab;">Hescom Under-Ground Cable Manager</b></a>
			  </div>
        <center>
			  <div class="login-box-body jumbotron " style="background-color:lavender;border: 5px solid #ccc;border-radius: 18px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" >
				<p class="login-box-msg" style="color:grey;"><b>Sign in</b></p>
				<form action="#" method="post" id="login_form">
					  <div class="form-group has-feedback" >
						<input type="text" id="change-transitions1" class="form-control email" data-toggle="dropdown" data-value="pulse" name="username"  placeholder="Email">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					  </div>
					  <div class="form-group has-feedback" id="change-transitions">
						<input type="password" id="change-transitions2"class="form-control password" data-toggle="dropdown" data-value="pulse" name="password" placeholder="Password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					  </div>
					<div class="row">
          <div class="col-xs-4 text-center"></div>
						<div class="col-xs-4 text-center">
						  <input type="submit" name="submit" class="btn btn-primary btn-block btn-flat" style="background-color:navy;"value="Sign In"/>
						</div>
					</div>
				</form>
	      <div class="help-block text-center"></center>
	 
	</div>
  </div>
</div>

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="plugins/jQueryUI/jquery-ui.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
 <script src="bootstrap/js/animation.js"></script>
 <script src="bootstrap/js/jquery.cookie.js"></script>
 
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' 
    });
  });
  $('.carousel').carousel({
        interval: 5000 
    })
	
$(document).ready(function(){
	
	
});
</script>
</body>
</html>
