<?php ini_set('display_errors', 1);
if (session_id() == '') {
  session_start();
  $uid = $_SESSION['uid'];
  $usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
  header("Location: login.php");
}
include ('pages/required/db_connection.php');
include ('pages/required/functions.php');
include ('pages/required/tables.php');

$loggen_in_query = "SELECT u.*,DATE_FORMAT(u.CDATE, '%b %Y') AS member_since
								FROM users u
								WHERE u.UID=" . $uid;
$login_query_result = db_one($loggen_in_query);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Hescom | User Profile</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include ('header.php'); ?>
    <?php include ('sidebar.php'); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          User Profile
        </h1>
      </section>
      <section class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="images/hescom.jpg"
                  alt="User profile picture">
                <p class="text-muted text-center"> <?php echo $_SESSION['name'] ?></p>
              </div>
            </div>
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
              </div>
              <div class="box-body">
                <strong><i class="fa fa-user margin-r-5"></i> Name</strong>
                <p class="text-muted">
                  <?php echo $login_query_result['NAME']; ?>
                </p>
                <hr>
                <strong><i class="fa fa-building margin-r-5"></i> User-Type</strong>
                <p class="text-muted"><?php echo $login_query_result['UTNO']; ?></p>
                <hr>
                <strong><i class="fa fa-envelope margin-r-5"></i> Email id</strong>
                <p class="text-muted">
                  <?php echo $login_query_result['EMAIL']; ?>
                </p>
                <hr>
                <strong><i class="fa fa-map-marker margin-r-5"></i> Username</strong>
                <p class="text-muted"><?php echo $login_query_result['USERNAME']; ?></p>
                <hr>
                <strong><i class="fa fa-mobile margin-r-5"></i> Mobile</strong>
                <p class="text-muted"><?php echo $login_query_result['PHONE']; ?></p>
                <hr>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="tab-pane" id="settings">
              <div class="Update_Notification"></div>
              <form method="POST" id="profile_update" name="profile_update" class="form-horizontal">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="hidden" class="form-control" name="login_id" value="<?php echo $uid; ?>">
                    <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name"
                      value="<?php echo $login_query_result['NAME']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inputUsername" placeholder="Username"
                      value="<?php echo $login_query_result['USERNAME']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inputEmail" placeholder="email"
                      value="<?php echo $login_query_result['EMAIL']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputMobile" class="col-sm-2 control-label">Mobile</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="inputMobile" placeholder="Mobile"
                      value="<?php echo $login_query_result['PHONE']; ?>">
                  </div>
                </div>
                <div style="width:230px;" align="center">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary pull-right" name="profile_update"> Update </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <?php include ('footer.php'); ?>
  </div>
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script>
    $(document).ready(function () {
      $(document).on('submit', '#profile_update', function (e) {
        e.preventDefault();
        $.ajax({
          url: 'ajax/profile_update.ajax.php',
          type: 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function (data) {
            $('.Update_Notification').html(data);
            setTimeout(function () {
              window.location.reload();
            }, 1000);
          }
        });
      });
    });
  </script>>
</body>

</html>