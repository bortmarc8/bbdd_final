<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="index.css">
	<title>Diskover Login</title>
</head>
<body>
<?php 
if (isset($_POST['usu_crear']) && isset($_POST['psw_crear']) && $_POST['psw_crear'] == $_POST['psw_crear2']) {
	$username = $_POST['usu_crear'];
	$password = $_POST['psw_crear'];
	$data = file_get_contents($_FILES['foto']['tmp_name']);
	$dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
	$query = $dbh->query("SELECT id from users where username = '$username'")->fetch();

	if (!$query) {
		$stmt = $dbh->prepare("insert into users values('',?,?,?)");
		$stmt->bindParam(1,$username);
		$stmt->bindParam(2,$password);
		$stmt->bindParam(3,$foto);
		$stmt->execute();

		session_start();
		$_SESSION['id-user']=$query[0];
		$_SESSION['username-user']=$username;
		header('Location: index.php');
	}
	else
	{
		if (isset($_SESSION['id-user'])){
			session_destroy();
		}
		echo("<script>alert('Este usuario ya está en la plataforma')</script>");
	}
}
else
{
	if (isset($_POST['btnok'])){
		echo("<script>alert('Error al rellenar el formulario, intentalo de nuevo')</script>");
	}
}

 ?>
 <div class="body">
	<form action="" method="post">
		<img src="local_resources/img/user.png" alt="Avatar" class="avatar">

		<input type="text" placeholder="Usuario" name="usu_crear" required>
	
		<input type="password" placeholder="Contraseña" name="psw_crear" required>

		<input type="password" placeholder="Repetir contraseña" name="psw_crear2" required>

		<input required="true" type="file" accept="image/*" name="foto" required>
		<br>
		<button id="ok_btn" name="btnok" type="submit">Crear cuenta</button>
		</form>
		<a style="width: 50%; margin-top: 35px; margin-left:25%;" href="index.php"><button style="background-color: tomato; width: 100%; margin-top: 0px;">Volver</button></a>
	
</div>
</body>
</html>