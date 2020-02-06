<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php
function imprimirFormulario ($idUsuario, $email, $nombre, $apellidos, $direccion, $telefono) {
?>
	<form>
		<div class="form-group">
			<label for="idUsuario">ID</label>
			<input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario; ?>" readonly="readonly" />
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly="readonly" />
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
	<h1 class="mt-5">Actualizar usuario</h1>
	
	<?php
	if (!isset($_REQUEST['guardar'])) {
		
		$usuario=recoge("usuario");
		$pag=recoge("pag");
		if ($usuario==""){
			header("Location: gestionarUsuarios.php");
			exit(); //die();
		}
		$user=seleccionarUsuario($usuario);
		
		if (empty($user)) {
			header("Location: gestionarUsuarios.php");
			exit();
		}
		
		if ($pag==""){
			header("Location: gestionarUsuarios.php");
			exit(); //die();
		}
		
		if ($pag=="editar") {
			imprimirFormulario ($idUsuario, $email, $nombre, $apellidos, $direccion, $telefono);
		}
		else {
			$idUsuario=recoge("idUsuario");
			$email=recoge("email");
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
		}
	}
	else {
		$usuario=recoge("usuario");
		$password=recoge("password");
		$newPassword1=recoge("newPassword1");
		$newPassword2=recoge("newPassword2");
		
		$user=seleccionarUsuario($usuario);
		$hash=$user['password'];

		$errores="";

		if (!password_verify($password, $hash)) {
			$errores=$errores."<li>La contraseña anterior no es correcta</li>";
		}
		if ($newPassword2!=$newPassword1 or $newPassword1=="") {
			$errores=$errores."<li>La nueva contraseña no coincide</li>";
		}
		
		if ($errores!="") {
			echo "<h2>Errores:</h2> <ul>$errores</ul>";
			imprimirFormulario($usuario);
		}
		else {
			$ok=actualizarUsuario($usuario, $newPassword1);
			if ($ok!=0) {
				echo "<div class='alert alert-success' role='alert'> El usuario $usuario ha sido actualizado correctamente </div>";
				echo "<p><a href='index.php?pagina=usuario' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no actualizado </div>';
				imprimirFormulario($usuario);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>