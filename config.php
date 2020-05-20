<!DOCTYPE html>
<html>
<head>
    <title>Config</title>
</head>
<body>
<?php
if(isset($_POST["btnGenerarBBDD"])){
@$conexion=new mysqli ("localhost", "root", "");  

if (!$conexion)
{
  echo ('No pudo conectarse: ' . mysql_error());
  exit;
}

@$resultado = $conexion->query("CREATE DATABASE IF NOT EXISTS `diskover2` CHARSET UTF8;");
if (!$resultado)
  echo "Error al conectar con la base de datos.";
else
{
    $conexion->select_db("diskover2");
    $resultado = $conexion->query("CREATE TABLE if not exists `users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `img` MEDIUMBLOB NULL , PRIMARY KEY (`id`));");
}
if (!$resultado)
    echo "Error al crear la tabla users.";
  else
  {
    $resultado = $conexion->query("CREATE TABLE if not exists `songs` ( `id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(255) NOT NULL , `Album` VARCHAR(255) NOT NULL , `Artist` VARCHAR(255) NOT NULL , `Uploader` INT(11) NOT NULL , `Hash` VARCHAR(50) NOT NULL , `File` LONGBLOB NOT NULL , `Pic` MEDIUMBLOB NULL , PRIMARY KEY (`id`), CONSTRAINT FK_Uploader FOREIGN KEY (`uploader`) REFERENCES `users`(`id`) ON UPDATE CASCADE ON DELETE CASCADE);");
    if (!$resultado)
      echo "Error al crear la tabla songs.";
        else
        echo "La base de datos está instalada correctamente";
}
}
?>
<div class="body">
    <h1>Por el peso de los archivos a subir es posible que tengas que modificar el archivo my.ini y reemplazar su contenido por el del que te dejo directorio raíz de la aplicación</h1>
    <form method="post">
        <button name="btnGenerarBBDD" type="submit">Generar BBDD</button>
    </form>
</div>
</body>
</html>