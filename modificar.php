<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="modificar.css">
	<title>Diskover Search</title>
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
 <div class="body">
	<form method="post" enctype="multipart/form-data">
		<br>
		<input required="true" type="file" accept="audio/*" name="cancion" placeholder="Seleccionar">
		<br>
	 	<button type="submit" name="btn" id="uploadbtn">Buscar</button>
    </form>
</div>
<div class="body">
<?php

if (isset($_POST['btn'])) {
    $dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
    $data = file_get_contents($_FILES['cancion']['tmp_name']);
    $dataString = sha1(strval($data));
    $query = $dbh->query('select Name,Album,Artist from songs where hash = "'.$dataString.'" and uploader = "'.$userID.'"')->fetchAll();
    if (!$query) {
        echo "<script>alert('Aún no tenemos esta canción en el sistema');</script>";
    }
    else
    {
        $_SESSION["hash-img"] = $dataString;
        $query = $dbh->query("SELECT Name,Album,Artist from songs where Hash = '$dataString' and uploader = '$userID'")->fetchAll();
        echo '<form method="post" enctype="multipart/form-data">
            <input required="true" value="'.$query[0][0].'" type="text" placeholder="Título" name="titulo">
            <br>
            <input required="true" type="text" value="'.$query[0][1].'" placeholder="Álbum" name="album">
            <br>
            <input required="true" type="text" value="'.$query[0][2].'" placeholder="Autor" name="artista">
            <br>
            <br>
             <button type="submit" name="mod" id="uploadbtn">Modificar</button>
             <button type="submit" name="btn_borrar" style="background-color: tomato;" id="uploadbtn">Borrar</button>';
    }
}else if (isset($_POST['btn_borrar'])) {
    $dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
    $dataString = $_SESSION["hash-img"];
    $query = $dbh->prepare('DELETE from songs where Hash = "'.$dataString.'"and uploader = "$userID"')->execute();
}else if (isset($_POST['mod'])) {
    $dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
    $dataString = $_SESSION["hash-img"];
    $name_query = $_POST["titulo"];
    $album_query = $_POST["album"];
    $autor_query = $_POST["artista"];
    $userID = $_SESSION["id-user"];
    $query = $dbh->prepare('UPDATE `songs` SET `Name` = "'.$name_query.'", `Album` = "'.$album_query.'", `Artist` = "'.$autor_query.'" WHERE `songs`.`hash` = "'.$dataString.'" and uploader = "'.$userID.'"')->execute();
}


?>
<div class="body">

</form>
</div>
</div>
</body>
</html>