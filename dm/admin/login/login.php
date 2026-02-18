<?php

require_once('../php/config.php');
require_once('../php/db.php');
require_once('../php/utils.php');
require_once('../php/start.php');
//require_once('../php/session.php');
require_once('../../../wp/wp-load.php');

$err = 0;
$authorized = 0;
if (isset($_POST['BtnOK']) && $_POST['BtnOK']=="Login") {
	$username = $_POST['TxtUsername'];
	$password = $_POST['TxtPassword'];
	//validate
	
	if ($username=="") {
		$err = 1;	
	}
	if ($password=="") {
		$err = 1;	
	}
	
	if ($err==0) {
            session_start();
            
            $sql = "SELECT * FROM B5iyk_users WHERE user_login=?";
            $users = $db1->getRS($sql,array($username));
            
            for($i=0;$i<count($users);$i++){
                $hash = $users[$i]['user_pass'];
                if(wp_check_password($password, $hash) === TRUE){$authorized = 1; $arrItem = $i;}
            }
            
            if ($authorized === 1) {

                $_SESSION['KARCHER-AUTHORIZED'] = 1;
                $_SESSION['KARCHER-USER-ID'] = $users[$arrItem]['ID'];
                //$_SESSION['package'] = $user->get_package();
                $_SESSION['KARCHER-USER-FULLNAME'] = $users[$arrItem]['display_name'];

                $_SESSION['KARCHER-START'] = time(); // taking now logged in time
                if(!isset($_SESSION['KARCHER-EXPIRE'])){
                    $_SESSION['KARCHER-EXPIRE'] = $_SESSION['KARCHER-START'] + (1* 28800) ; // ending a session in 30 seconds
                }

                header('Location: '.app::$host.'admin.php');
            }
            else
            {
                $err = 'Όνομα χρήστη ή Κωδικός πρόσβασης είναι λάθος';
            }
	}
        else
        {
            $err = 'Όνομα χρήστη ή Κωδικός πρόσβασης είναι λάθος';
        }
	
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kaercher-marine CRM</title>
<link href="../css/grid.css" rel="stylesheet" type="text/css" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<style>

form.login {
	width:500px;
	margin:auto;
	margin-top:100px;
	padding:20px;
	border:1px solid rgb(200,200,200);
	border-radius:10px;
	
}

body {
    background-image: none;
}



</style>


</head>

<body>
<form class="login" action="login.php?login=1" method="post">
<h1>Kaercher-marine - Admin</h1>
<?php if($err != 0 || $err != ''){ ?>
<div class="col-12"><p style="color:red;"><?php echo $err; ?></p></div>
<?php } ?>
<div class="col-5">Όνομα χρήστη</div>
<div class="col-7">
<input name="TxtUsername" type="text" />
</div>

<div class="col-5">Κωδικός πρόσβασης</div>
<div class="col-7">
<input name="TxtPassword" type="password" />
</div>

<div class="col-5"></div>
<div class="col-7">
<input name="BtnOK" type="submit" value="Login" />
</div>

<div style="clear:both"></div>

</form>


</body>
</html>
