<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php
function imprimirFormulario ($idPedido, $estado) {
?>

	<form>
		<div class="form-group">
			<label for="idProducto">ID</label>
			<input type="text" class="form-control" id="idPedido" name="idPedido" value="<?php echo $idPedido; ?>" readonly="readonly" />
		</div>
		<div class="form-group">Estado:
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="estado" id="Preparando" value="Preparando" <?php if ($estado=='Preparando') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="Preparando">Preparando</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="estado" id="Enviado" value="Enviado" <?php if ($estado=='Enviado') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="Enviado">Enviado</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="estado" id="Entregado" value="Entregado" <?php if ($estado=='Entregado') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="Entregado">Entregado</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="estado" id="Cancelado" value="Cancelado" <?php if ($estado=='Cancelado') {echo "checked='checked'";} ?>/>
				<label class="form-check-label" for="Cancelado">Cancelado</label>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='gestionarPedidos.php' class='btn btn-danger'>Cancelar</a>
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
	<h1 class="mt-5">Actualizar estado del pedido</h1>
	
	<?php
	if (!isset($_REQUEST['guardar'])) {
		
		$idPedido=recoge("idPedido");
		
		if ($idPedido==""){
			header("Location: gestionarPedidos.php");
			exit(); //die();
		}
		
		$pedido=seleccionarPedido($idPedido);
		
		if (empty($pedido)) {
			header("Location: gestionarPedidos.php");
			exit();
		}

		$idPedido=$pedido['idPedido'];
		$estado=$pedido['estado'];
		
		imprimirFormulario ($idPedido, $estado);
	}
	else {
		$idPedido=recoge("idPedido");
		$estado=recoge("estado");
		
		$errores="";
		
		if ($estado=="") {
			$errores=$errores."<li>El campo estado no puede estar vacío</li>";
		}

		if ($errores!="") {
			echo "<h2>Errores:</h2> <ul>$errores</ul>";
			imprimirFormulario ($idPedido, $estado);
		}
		else {
			$ok=actualizarEstado($idPedido, $estado);
			if ($ok!=0) {
				echo "<div class='alert alert-success' role='alert'> El pedido $idPedido ha sido actualizado correctamente </div>";
				echo "<p><a href='gestionarPedidos.php' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Producto no actualizado </div>';
				imprimirFormulario ($idPedido, $estado);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>