<?php 
session_start();
if (isset($_SESSION['id-user'])) {
	$username = $_SESSION['username-user'];
	$userID = $_SESSION['id-user'];
}else{
	header('Location: index.php');
}
//session_destroy();
?>
 <div class="header">
 	<div class="header_container">
	 	<div class="botonera">
            <a href="index.php"><button style="background-color=red;">Cerrar sesión</button></a>
            <a href="modificar.php"><button>Modificar canción</button></a>
	 		<a href="config.php"><button>Configuración</button></a>
		 	<a href="buscar.php"><button>Buscar canción</button></a>
		  	<a href="Catalogo.php"><button>Catalogo</button></a>
			<a href="misSubidas.php"><button>Mis subidas</button></a> 
            <a href="subir.php"><button>Subir canción</button></a>
	 	</div>
	 	<div class="divNombre">
	 		<p id="username_header">Bienvenido: <?php echo "$username"; ?></p>
	 	</div>	
 	</div>
 </div>

