<?php 
ini_set('display_errors', 1);
?>
<?php 

if (session_id() == '') {
	session_start();
	$uid = $_SESSION['uid'];
	$usertype = $_SESSION['usertype'];
}

if (!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}
  include('../pages/required/db_connection.php');
  include('../pages/required/tables.php');
  require('../pages/required/functions.php');
  ?>

<?php 
{
    
    $name = $_POST['inputName'];
    $email = $_POST['inputEmail'];
    $Username = $_POST['inputUsername'];
  //$Password = $_POST['inputPassword'];
    $Mobile = $_POST['inputMobile'];
    $uid1 = $_POST['login_id'];
  // code...
  //echo $login_id;
    $table_name = "users";
    $res_set_values = 'NAME="'.$name.'",EMAIL="'.$email.'",USERNAME="'.$Username.'",PHONE='.$Mobile;
    $res_where_val = "UID=".$uid1;
    
    $res_update_result = db_update($table_name,$res_set_values,$res_where_val);
    

    if($res_update_result==1){
    
        ?>
        <div class="callout callout-warning">
              <h4>Successful</h4>
              <?php //echo "The file ". htmlspecialchars( basename($res_doc)). " has been uploaded.";?>
              <p>Profile Updated Successfully.</p>
        </div>
        <?php }else{?>
          <div class="callout callout-danger">
            <h4>Unable to Update Profile</h4>
            <p>Check Out.</p>
            </div>
        <?php }
    //mysqli_query($con,$sql);
    //echo '<script>alert("Details Updated successfully")</script>'; 
    }
  ?>