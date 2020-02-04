<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<main role="main" class="container">
	<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:index.php");
	}
	?>
	<h1 class="mt-5">Borrar producto</h1>
	
	<?php
		$idProducto=recoge("idProducto");
		
		if ($idProducto==""){
			header("Location: gestionarProductos.php");
			exit(); //die();
		}

		$ok=borrarProducto($idProducto);
			if ($ok!=0) {
				echo "<div class='alert alert-success' role='alert'> El producto $idProducto ha sido puesto en offline </div>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Producto no borrado </div>';
			}
		echo "<p><a href='gestionarProductos.php' class='btn btn-primary'>Volver al listado</a></p>";
	?>
	
</main>


<?php require_once "inc/pie.php"; ?>