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
		
		//number of incorrect guesses allowed
		$bad_login_limit = 6;
		//amount of time the user is locked out for
		$lockout_time = 600;
		
		
		try {
			//using the submitted username to get the number of attempts and the time since the last request
			$stmt = $db->prepare('SELECT log_time, failed_count FROM CMS_users WHERE username = :username');
			$stmt->execute(array(':username' => $username));		
			$row = $stmt->fetch();
			
			//strtotime converts the stored datetime to unic time for the maths
			$first_failed_login = strtotime($row['log_time']);
			$failed_login_count = $row['failed_count']; 
			
			
			
		} catch(PDOException $e) {
				//just outputs any error messages
				   echo $e->getMessage();
		}
		
		//so if the user exists the $row would return false so first finds username exists
		//then check the number of logins isnt over the limit
		//then check the timer hasnt expired
		if($row && ($failed_login_count >= $bad_login_limit) && (time() - $first_failed_login < $lockout_time)) {
	    	$message = '<p class="error">Youre currently locked out, try again in 10 minutes</p>';	
		} else {
			//calls on the user class in the classes library, works without definition because of the __autoload in config
			if($user->login($username,$password)){ 
				//if login successful, resets the timer
				$failed_login_count = 0;
				//now resets all the login counters
				$stmt = $db->prepare('UPDATE CMS_users SET log_time = :logTime, failed_count = :failedCount WHERE username = :username');
				$stmt->execute(array(
					':logTime' => date('Y-m-d H:i:s'),
					':failedCount' => $failed_login_count,
					':username' => $username
					)
				);
				
				//logged in return to index page
				header('Location: index.php');
				
				exit;


			} else {
				//just a message saying loggin on had an error
				$message = '<p class="error">Wrong username or password</p>';
				
				//increments the login count
				$failed_login_count++;
				
				$stmt = $db->prepare('UPDATE CMS_users SET log_time=:logTime, failed_count=:failedCount WHERE username = :username');
				$stmt->execute(array(
					':username' => $username,
					':failedCount' => $failed_login_count,
					':logTime' => date('Y-m-d H:i:s')
					)
				);
			}
		}

	}//end if submit

	if(isset($message)){ echo $message; }
	?>
	
	<!-- post method is used in the POST request at the top of the page and is used to 
		process he data of the above form javascript on the onsubmit greys the submit button 
		during submission to prevent multiple clicks-->
	<form action=""  method="post" onsubmit="hideSubmit()">
		<p><label>Username</label>
		<input id="username" type="text" name="username" value=""  autofocus/></p>
		<p><label>Password</label>
		<input type="password" name="password" value=""  /></p>
		<p><label></label>
		<input type="submit" id="submit-button" name="submit" value="Login"  /></p>
	</form>

</div>
	
	 <script language="JavaScript" type="text/javascript">
	 	//focus on input field, there ya go rob ;)
		window.onload = function() {
    		document.getElementById('username').focus();
			};
		
		function hideSubmit(){
				console.log('hello');
				document.getElementById('submit-button').style.display = 'none';	
		};
	</script>
	
</body>
</html>

