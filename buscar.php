<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="buscar.css">
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
	$dbh = new PDO("mysql:host=localhost;dbname=diskover", "root", "");
if (isset($_POST['btn'])) {
    $data = file_get_contents($_FILES['cancion']['tmp_name']);
    $dataString = sha1(strval($data));
    $query = $dbh->query("SELECT * from songs where Hash = '$dataString'")->fetchAll();
    
    if (!$query) {
        echo "<script>alert('Aún no tenemos esta canción en el sistema');</script>";
    }
    else
    {
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
    }
}



?>
</div>
</body>
</html>