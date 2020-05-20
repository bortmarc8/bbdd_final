<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mis subidas</title>
	<link rel="stylesheet" type="text/css" href="misSubidas.css">
</head>
 <?php 
$dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
 ?>
<body>
<?php require("header.php") ?>
 <div class="body">
 	<?php 
 		$query = $dbh->query("SELECT Name,Album,Artist,File,Pic from songs where uploader = $userID")->fetchAll();
 		for ($i=0; $i < count($query); $i++) { 
 			$background = 'data:image/png;base64,'.base64_encode($query[$i]['Pic']);
 			$song = 'data:image/mp3;base64,'.base64_encode($query[$i]['File']);
 			echo '<div class="song_Container">
 		<div class="song_Container_info" style="background-image:url('.$background.'">
			<p>'.$query[$i]["Name"].'</p>
	 		<div class="btn_Play">
	 		</div>
	 		<p>'.$query[$i]["Album"].'</p>
	 		<p>'.$query[$i]["Artist"].'</p>
	 		<br>
	 		<br>
		</div>
 	</div>';}
 	 ?>
 	</div>
</body>
</html>