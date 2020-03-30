<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>


<?php
function imprimirFormulario($email) {
?>

	<form>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly="readonly" />
		</div>
		<div class="form-group">
			<label for="password">Password anterior:</label>
			<input type="password" class="form-control" id="password" name="password" />
		</div>
		<div class="form-group">
			<label for="newPassword1">Nueva password:</label>
			<input type="password" class="form-control" id="newPassword1" name="newPassword1" />
		</div>
		<div class="form-group">
			<label for="newPassword2">Repite la password nueva:</label>
			<input type="password" class="form-control" id="newPassword2" name="newPassword2" />
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
	<h1 class="mt-5">Cambiar contraseña</h1>
	
	<?php
	if (!isset($_REQUEST['guardar'])) {
		
		$usuario=recoge("usuario");
		
		if ($usuario==""){
			header("Location: gestionarUsuarios.php");
			exit(); //die();
		}
		$user=seleccionarUsuarioId($usuario);
		
		if (empty($user)) {
			header("Location: gestionarUsuarios.php");
			exit();
		}
		$email=$user["email"];
		imprimirFormulario($email);
	}
	else {
		$email=recoge("email");
		$password=recoge("password");
		$newPassword1=recoge("newPassword1");
		$newPassword2=recoge("newPassword2");
		
		$user=seleccionarUsuario($email);
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
			imprimirFormulario($email);
		}
		else {
			$ok=actualizarContraseña($email, $password);
			if ($ok!=0) {
				echo "<div class='alert alert-success' role='alert'> El usuario ha sido actualizado correctamente </div>";
				echo "<p><a href='gestionarUsuarios.php' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no actualizado </div>';
				imprimirFormulario($email);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>