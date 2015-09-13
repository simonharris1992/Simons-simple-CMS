<?php
//include config
require_once('../includes/config.php');


//check if already logged in
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
	 <script language="JavaScript" type="text/javascript">
	 	//focus on input field, there ya go rob ;)
		window.onload = function() {
    		document.getElementById("username").focus();
		};
    </script>
</head>
<body>

<div id="login">

	<?php

	//process login form if submitted, notice how on the form below the method is post, that links to this
	if(isset($_POST['submit'])){
		// trim() removes whitespace from the inserted data, useful to ensure no space before or after
		//altering the request
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		//calls on the user class in the classes library, works without definition because of the __autoload in config
		if($user->login($username,$password)){ 

			//logged in return to index page
			header('Location: index.php');
			exit;
		

		} else {
			//just a message saying loggin on had an error
			$message = '<p class="error">Wrong username or password</p>';
		}

	}//end if submit

	if(isset($message)){ echo $message; }
	?>
	
	<!-- post method is used in the POST request at the top of the page and is used to 
		process he data of the above form -->
	<form action="" method="post">
	<p><label>Username</label><input id="username" type="text" name="username" value=""  autofocus/></p>
	<p><label>Password</label><input type="password" name="password" value=""  /></p>
	<p><label></label><input type="submit" name="submit" value="Login"  /></p>
	</form>

</div>
</body>
</html>
