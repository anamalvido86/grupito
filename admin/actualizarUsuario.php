<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php
function imprimirFormulario($usuario) {
?>

	<form>
		<div class="form-group">
			<label for="usuario">Usuario</label>
			<input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>" readonly="readonly" />
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
		<a href='index.php?pagina=usuario' class='btn btn-danger'>Cancelar</a>0
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
		
		if ($usuario==""){
			header("Location: index.php?pagina=usuario");
			exit(); //die();
		}
		$user=seleccionarUsuario($usuario);
		
		if (empty($user)) {
			header("Location: index.php?pagina=usuario");
			exit();
		}

		imprimirFormulario($usuario);
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