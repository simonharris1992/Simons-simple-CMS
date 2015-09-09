<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
	
	<!--- THIS PHP CODE PULLS THE DATA FROM THE DATABSE FOR USE --->
		<?php
			try {
				//create the query to select the post contents from the database through the PDO
				$stmt = $db->query('SELECT postCont FROM posts');
				//uses the fetchAll to get the entire column and put it into the $r as an array of the content
				$r = $stmt->fetchAll(PDO::FETCH_COLUMN);
			} catch(PDOException $e) {
				//just outputs any error messages
				   echo $e->getMessage();
			}
		?>
	
	
	<!--- PUT YOUR BODY HTML/CSS BELOW THIS POINT --->
	<div id="wrapper">
		<h1><?php echo $r[0]; ?></h1>
		<hr />
		<h2><?php echo $r[1]; ?></h2>
		<p><?php echo $r[2]; ?></p>	
		
	</div>
			
</body>
</html>