<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<main role="main" class="container">
<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:login.php");
	}
?>
	<h1 class="mt-5">Borrar Usuario</h1>
	
	<?php
		$usuario=recoge("usuario");
		
		if ($usuario==""){
			header("Location: index.php?pagina=usuario");
			exit(); //die();
		}

		$ok=borrarUsuario($usuario);
			if ($ok!=0) {
				echo "<div class='alert alert-success' role='alert'> El usuario $usuario ha sido borrado correctamente </div>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no borrado </div>';
			}
		echo "<p><a href='gestionarUsuarios.php' class='btn btn-primary'>Volver al listado</a></p>";
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>