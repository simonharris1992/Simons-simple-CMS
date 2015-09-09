<?php
//include config, for database and class addition
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 
	//just preparing a statement to delete the post, remember that this is handled by the PDO
	$stmt = $db->prepare('DELETE FROM posts WHERE postID = :postID') ;
	//excuting the above prepared statment bur defining the postID from the one that was clicked
	$stmt->execute(array(':postID' => $_GET['delpost']));
	//if it is deleted this is a redirect
	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
   //just a javascript confirm box for when you choose to delete 
  function delpost(id, title)
    {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
		//links back to this page with the ?delpost= + id and if you see the above GET statement it removes
		//the table entry based on id.
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">
		
	<!-- simple include for the top menu -->
	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page, if added then displays as added
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Descripton</th>
		<th>Content</th>
		<th>Last Modified</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT postID, postTitle, postDate, postDesc,postCont FROM posts ORDER BY postID ASC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				//take note that this is the postID minus one because the postID start at 1 however the
				//aray caused by fetchAll starts at 0. So to make it so they match you just do postID-1
				echo '<td>'.($row['postID']-1). '</td>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.$row['postDesc'].'</td>';
				echo '<td>'.$row['postCont'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<!-- this links to the edit post php page -->
					<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> | 
					<!-- this is a link to the above function to call i prompt to delete the code -->
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		//grabs any PDO error, this will occur id the above statements contain a problem as it is using try/catch
			} catch(PDOException $e) {
				//this code just echos the PDO error (if there is one)
			    echo $e->getMessage();
			}
	?>
	</table>
    <!-- links to the add post page -->
	<p><a href='add-post.php'>Add Post</a></p>

</div>

</body>
</html>
