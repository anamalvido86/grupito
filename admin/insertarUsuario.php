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
			<input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>"/>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password"/>
		</div>
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='index.php?pagina=usuario' class='btn btn-danger'>Cancelar</a>
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
		$usuario="";
		imprimirFormulario($usuario);
	}
	else {
		$usuario=recoge("usuario");
		$password=recoge("password");
		
		$errores="";
		
		$user=seleccionarUsuario($usuario);
		
		if (!empty($user)) {
			$errores=$errores."<li>El usuario ya existe</li>";
		}
		
		if ($usuario=="") {
			$errores=$errores."<li>El campo usuario no puede estar vacío</li>";
		}
		if ($password=="") {
			$errores=$errores."<li>El campo password no puede estar vacío</li>";
		}
		
		if ($errores!="") {
			echo "<h2>Errores:</h2> <ul>$errores</ul>";
			imprimirFormulario($usuario);
		}
		else {
			$user=insertarUsuario($usuario, $password);
			if ($user!=0) {
				echo "<div class='alert alert-success' role='alert'> El usuario $usuario ha sido insertado correctamente </div>";
				echo "<p><a href='index.php?pagina=usuario' class='btn btn-primary'>Volver al listado</a></p>";
			} 
			else {
				echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no insertado </div>';
				imprimirFormulario($usuario);
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>