<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="index.css">
	<title>Diskover Login</title>
</head>
<body>
<?php 
session_start();
if (isset($_SESSION['id-user'])){
	unset($_SESSION['id-user']);
	session_destroy();
}

if (isset($_POST['uname']) && isset($_POST['psw'])) {
	$username = $_POST['uname'];
	$password = $_POST['psw'];
	$dbh = new PDO("mysql:host=localhost;dbname=diskover2", "root", "");
	$query = $dbh->query("SELECT id from users where username = '$username' and password = '$password'")->fetch();

	if ($query) {
		$_SESSION['id-user']=$query[0];
		$_SESSION['username-user']=$username;
		header('Location: Catalogo.php');
	}
	else
	{
		echo("<script>alert('Usuario y/o contraseña incorrectos')</script>");
	}
}

 ?>
 <div class="body">
	<form action="" method="post">
		<img src="local_resources/img/user.png" alt="Avatar" class="avatar">

		<input type="text" placeholder="Username" name="uname" required>
	
		<input type="password" placeholder="Password" name="psw" required>
		<br>
		<button id="ok_btn" type="submit">Login</button>
		</form>
		<a style="width: 50%; margin-top: 35px; margin-left:25%;" href="register.php"><button style="background-color: tomato; width: 100%; margin-top: 0px;">Crear nueva cuenta</button></a>
		<a style="width: 50%; margin-top: 35px; margin-left:25%;" href="configñ.php"><button style="background-color: darkblue; width: 100%; margin-top: 0px;">Crear BBDD</button></a>	
</div>
</body>
</html>