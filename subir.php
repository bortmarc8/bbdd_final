<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="subir.css">
	<title>Diskover Upload</title>
</head>
<body>
	<!-- MUY IMPORTANTE

Modificar conf del server para que funcione

## You can set .._buffer_pool_size up to 50 - 80 %
## of RAM but beware of setting memory usage too high
innodb_buffer_pool_size=16M
## Set .._log_file_size to 25 % of buffer pool size
innodb_log_file_size=1024M
innodb_log_buffer_size=8M
innodb_flush_log_at_trx_commit=1
innodb_lock_wait_timeout=28800
	-->
	<?php include("header.php");?>
	<?php 
	$dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
	if (isset($_POST['btn'])) {
		$data = file_get_contents($_FILES['cancion']['tmp_name']);
		$pic = file_get_contents($_FILES['pic']['tmp_name']);
		$dataString = sha1(strval($data));
		$query = $dbh->query("SELECT id from songs where Hash = '$dataString'")->fetch();

		if (!$query) {
			$stmt = $dbh->prepare("insert into songs values('',?,?,?,?,?,?,?)");
			$stmt->bindParam(1,$_POST['titulo']);
			$stmt->bindParam(2,$_POST['album']);
			$stmt->bindParam(3,$_POST['artista']);
			$stmt->bindParam(4,$_SESSION["id-user"]);
			$stmt->bindParam(5,$dataString);
			$stmt->bindParam(6,$data);
			$stmt->bindParam(7,$pic);
			$stmt->execute();
			echo "<script>alert('Correcto, se ha subido el archivo al sistema');</script>";
		}
		else
		{
			echo "<script>alert('Error, la canción que vas a subir ya está en el sistema.');</script>";
		}		
	}
	?>
 <?php 
if (isset($_SESSION['id-user'])) {
	$username = $_SESSION['username-user'];
	$userID = $_SESSION['id-user'];
}else{
	header('Location: index.php');
}
//session_destroy();
 ?>
 <div class="body">
	<form method="post" enctype="multipart/form-data">
		<input required="true" type="text" placeholder="Título" name="titulo">
		<br>
		<input required="true" type="text" placeholder="Álbum" name="album">
		<br>
		<input required="true" type="text" placeholder="Autor" name="artista">
		<br>
		<input required="true" type="file" accept="audio/*" name="cancion">
		<br>
		<input required="true" type="file" accept="image/*" name="pic">
		<br>
		<br>
	 	<button type="submit" name="btn" id="uploadbtn">Subir</button>
	</form>
</div>
</body>
</html>