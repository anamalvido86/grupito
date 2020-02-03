<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/encabezado.php"; ?>



<main role="main" class="container">
	

	<h1 class="mt-5">Menú principal</h1>
	
<?php	
	if (!isset($_SESSION["nombre"])) {
		header("Location:login.php");
	}
	echo "<div class='alert alert-success' role='alert'> Bienvenido ".$_SESSION["nombre"]."</div>";
?>

	<a href="gestionarProductos.php" class="btn btn-info">Gestionar productos</a> 
	<a href="gestionarUsuarios.php" class="btn btn-info">Gestionar Usuarios</a> 
	
	<a href="index.php" class="btn btn-primary">Cerrar sesión </a>

</main>

<?php require_once "inc/pie.php"; ?>