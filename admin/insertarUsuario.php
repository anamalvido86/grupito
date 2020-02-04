<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php
function imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono) {
?>

	<form>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>"/>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password"/>
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
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='gestionarUsuarios.php' class='btn btn-danger'>Cancelar</a>
	</form>
<?php
}
?>

<main role="main" class="container">
<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:login.php");
	}
?>
	<h1 class="mt-5">Insertar nuevo usuario</h1>
	
	<?php
	if (!isset($_REQUEST['guardar'])) {
		$email="";
		$nombre="";
		$apellidos="";
		$direccion="";
		$telefono="";
		imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
	}
	else {
		$email=recoge("email");
		$password=recoge("password");
		$nombre=recoge("nombre");
		$apellidos=recoge("apellidos");
		$direccion=recoge("direccion");
		$telefono=recoge("telefono");
		
		$errores="";
		
		$usuario=seleccionarUsuario($email);
		
		if (!empty($usuario)) {
			$errores=$errores."<li>El usuario ya existe</li>";
		}
		
		if ($email=="") {
			$errores=$errores."<li>El campo email no puede estar vacío</li>";
		}
		if ($password=="") {
			$errores=$errores."<li>El campo password no puede estar vacío</li>";
		}
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
			$usuario=insertarUsuario($email, $password, $nombre, $apellidos, $direccion, $telefono);
			if ($usuario!=0) {
				echo "<div class='alert alert-success' role='alert'> El usuario $usuario ha sido insertado correctamente </div>";
				echo "<p><a href='gestionarUsuarios.php' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no insertado </div>';
				imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>