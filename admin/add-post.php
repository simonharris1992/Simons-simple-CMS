<?php 
//include config, for database and class addition
require_once('../includes/config.php');

//if not logged in redirect to login page, grabbed from the user class
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
 
	<!--- Script details for the form plugin -->
	<script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">CONTENT ADMIN PANEL</a></p>

	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect the form data form data
		extract($_POST);

		//very basic validation ensuring the feilds are not empty, if there are empty feild add them to the 
		//$errors array where they will be displayed.
		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		//on submission, if there was any errors they would have been added to the error array 
		//which would stop the sytem here
		if(!isset($error)){
			
			//using a try/catch brace to grab any PDO errors (if they orror) we are preparing 
			//then execuing the addition of the form data into the database
			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO posts (postTitle,postDesc,postCont,postDate) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
				//	this gives the vars in the prepare statements the values from the form
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					//this is just a way of formatting the date, called from the server time
					':postDate' => date('Y-m-d H:i:s')
				));

				//redirect to index page once it has been added, the added will be grabbed by a GET to know the
				//the currect message to display
				header('Location: index.php?action=added');
				//exit the try catch statement
				exit;
			
			//grabs any PDO error, this will occur id the above statements contain a problem as it is using try/catch
			} catch(PDOException $e) {
				//this code just echos the PDO error (if there is one)
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors (remember the above statement is just PDO problem) and cycles through the array to diplay them all if necesasry
	//$error will only have contents if any errors occured in the form validation
	if(isset($error)){
		//this loops through the errors array and just lists the errors if any occured
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>
	
	<!-- simple form for use with the php, the submit is linked to the if(isset($_POST['submit'])){}; function above -->
	<form action='' method='post'>

		<p><label>Title of the post, for quick identification</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Description (breif desciption for where on the page this goes)</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content, that you want it to say on the page</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		<!-- submit button -->
		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
