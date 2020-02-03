<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php
function imprimirFormulario ($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online) {
?>

	<form>
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>"/>
		</div>
		<div class="form-group">
			<label for="introDescripcion">Pequeña descripción</label>
			<input type="text" class="form-control" id="introDescripcion" name="introDescripcion" value="<?php echo $introDescripcion; ?>"/>
		</div>
		<div class="form-group">
			<label for="descripcion">Descripción</label>
			<input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>"/>
		</div>
		<div class="form-group">
			<label for="imagen">Imagen</label>
			<input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo $imagen; ?>"/>
		</div>
		<div class="form-group">
			<label for="precio">Precio original</label>
			<input type="text" class="form-control" id="precio" name="precio" value="<?php echo $precio; ?>"/>
		</div>
		<div class="form-group">
			<label for="precioOferta">Precio con oferta</label>
			<input type="text" class="form-control" id="precioOferta" name="precioOferta" value="<?php echo $precioOferta; ?>"/>
		</div>
		<div class="form-group">Online:
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="online" id="1" value="1" <?php if ($online=='1') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="1">Si</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="online" id="0" value="0" <?php if ($online=='0') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="0">No</label>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='gestionarProductos.php' class='btn btn-danger'>Cancelar</a>
	</form>
<?php
}
?>

<main role="main" class="container">
<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:index.php");
	}
?>
	<h1 class="mt-5">Insertar nuevo producto</h1>
	
	<?php
	if (!isset($_REQUEST['guardar'])) {
		$nombre="";
		$introDescripcion="";
		$descripcion="";
		$imagen="";
		$precio="";
		$precioOferta="";
		$online="";
		imprimirFormulario($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online);
	}
	else {
		$nombre=recoge("nombre");
		$introDescripcion=recoge("introDescripcion");
		$descripcion=recoge("descripcion");
		$imagen=recoge("imagen");
		$precio=recoge("precio");
		$precioOferta=recoge("precioOferta");
		$online=recoge("online");
		
		$errores="";
		
		if ($nombre=="") {
			$errores=$errores."<li>El campo nombre no puede estar vacío</li>";
		}
		if ($introDescripcion=="") {
			$errores=$errores."<li>El campo de pequeña descripcion no puede estar vacío</li>";
		}
		if ($descripcion=="") {
			$errores=$errores."<li>El campo descripcion no puede estar vacío</li>";
		}
		if ($imagen=="") {
			$errores=$errores."<li>El campo imagen no puede estar vacío</li>";
		}
		if ($precio=="") {
			$errores=$errores."<li>El campo precio no puede estar vacío</li>";
		}
		if ($precioOferta=="") {
			$errores=$errores."<li>El campo del precio en oferta no puede estar vacío</li>";
		}
		if ($online=="") {
			$errores=$errores."<li>El campo online no puede estar vacío</li>";
		}
		
		if ($errores!="") {
			echo "<h2>Errores:</h2> <ul>$errores</ul>";
			imprimirFormulario($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online);
		}
		else {
			$idProducto=insertarProducto($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online);
			if ($idProducto!=0) {
				echo "<div class='alert alert-success' role='alert'> El producto $idProducto ha sido insertado correctamente </div>";
				echo "<p><a href='gestionarProductos.php' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Producto no insertado </div>';
				imprimirFormulario($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>