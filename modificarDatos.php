<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="modificarDatos";
	  $titulo="Modificar datos";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>


<?php
function imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono) {
?>
	<form>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" readonly="readonly" value="<?php echo $email; ?>"/>
		</div>
		<div class="form-group">
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>"/>
		</div>
		<div class="form-group">
			<label for="apellidos">Apellidos:</label>
			<input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>"/>
		</div>
		<div class="form-group">
			<label for="direccion">Direccion:</label>
			<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>"/>
		</div>
		<div class="form-group">
			<label for="telefono">Telefono:</label>
			<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>"/>
		</div>
		<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='index.php' class='btn btn-danger'>Cancelar</a>
	</form>
<?php
}
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
		<h1 class="display-3">Editar datos</h1>
		<p >
		<?php
			if (!isset($_REQUEST['guardar'])) {
				$email=$_SESSION['email'];
				$usuario=seleccionarUsuario($email);
				$nombre=$usuario['nombre'];
				$apellidos=$usuario['apellidos'];
				$direccion=$usuario['direccion'];
				$telefono=$usuario['telefono'];
				imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
			}
			else {
				$email=recoge("email");
				$nombre=recoge("nombre");
				$apellidos=recoge("apellidos");
				$direccion=recoge("direccion");
				$telefono=recoge("telefono");
				
				$errores="";
				
				if ($nombre=="") {
					$errores=$errores."<li>El campo nombre no puede estar vacío</li>";
				}
				if ($apellidos=="") {
					$errores=$errores."<li>El campo apellidos no puede estar vacío</li>";
				}
				if ($direccion=="") {
					$errores=$errores."<li>El campo direccion no puede estar vacío</li>";
				}
				if ($telefono=="") {
					$errores=$errores."<li>El campo telefono no puede estar vacío</li>";
				}

				if ($errores!="") {
					echo "<h2>Errores:</h2> <ul>$errores</ul>";
					imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
				}
				else {
					$usuario=actualizarUsuario($email, $nombre, $apellidos, $direccion, $telefono);
					if ($usuario!=0) {
						echo "<div class='alert alert-success' role='alert'> El usuario ha sido modificado correctamente </div>";
						echo "<p><a href='misDatos.php' class='btn btn-primary'>Volver a mis datos</a></p>";
					} 
					else {
						echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no actualizado </div>';
						imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
					}
				}
			}
		?>
		</p>
    </div>
  </div>
</main>

<?php require_once("inc/pie.php"); ?>