<?php
session_start();
require_once 'datastore.php';
// initializing variables

$errors = array();

// connect to the database
// LOGIN USER
if (isset($_POST['login_user'])) {
$user_name=$_POST["user_name"];
$password=$_POST["password"];
 
  if (empty($user_name)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	//$password = md5($password);
  	//$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	//$results = mysqli_query($db, $query);
        $auth= user_auth($user_name,$password);
  	if ($auth == 1) {
  	  $_SESSION['userid'] = $user_name;
  	  //$_SESSION['success'] = "You are now logged in";
          /*************************************************/
              $arr = get_user_info($_SESSION['userid']);
              $info = extract($arr[0], EXTR_PREFIX_SAME, "wddx");
              //userid, userpass, username, role, userdept, uercol, personname
              //echo $personname;
              //print_r($arr);
              if($role==3 or $role==4)
              {$dispname=$personname." / ".$username;}
           else 
              {$dispname=$personname;}

              $_SESSION['dispname'] = $dispname;
              $_SESSION['username'] = $username;
              $_SESSION['role'] = $role;
              $_SESSION['userpass'] = $userpass;
              $_SESSION['deg_id'] = $deg_id;
              $_SESSION['deg_name'] = $deg_name;
           
          /*************************************************/
  	  header('location: home.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>