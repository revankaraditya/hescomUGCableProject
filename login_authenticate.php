<?php
    @ob_start();
	include('pages/required/db_connection.php');
	include('pages/required/tables.php');
	include('pages/required/functions.php');
	
    if( empty(session_id()) && !headers_sent()){
        session_start();
    }
		if(isset($_POST['submit'])){
			$uname = $_POST['username'];
			$password = $_POST['password'];
			if($uname!=''&&$password!=''){
				$encrypted_password  = md5($password);
				$query = "SELECT 
								* 
						  FROM 
								users
						 WHERE 
								USERNAME ='".$uname."' AND PASSWORD ='".$encrypted_password."';";
				$result = db_one($query);
				if($result!=NULL){
					$_SESSION['uid']=$result['UID'];
					$_SESSION['name']=$result['NAME'];
					$_SESSION['usertype']=$result['UTNO'];
					$_SESSION['logged_in']=1;
					    header('Location: index.php');
					    exit;
				  
				}else{
					login_message('<center><strong>Username or password is incorrect</strong></center>',0);
				}
			}else{
				login_message('<center><strong>Enter both username and password</center></strong>',0);
			}
		}
		@ob_end_flush();
?>