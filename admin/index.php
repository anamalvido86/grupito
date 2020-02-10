<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>

<?php 
if (isset($_SESSION["nombre"])) {
	unset($_SESSION["nombre"]);
}
?>

<?php
function imprimirFormulario($usuario) {
?>

	<form>
		<div class="form-group">
			<label for="usuario">Usuario:</label>
			<input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>"/>
		</div>
		<div class="form-group">
			<label for="password">Contraseña:</label>
			<input type="password" class="form-control" id="password" name="password"/>
		</div>
		<button type="submit" class="btn btn-primary" name="entrar" value="entrar">Entrar</button>
	</form>
<?php
}
?>

<main role="main" class="container">

	<h1 class="mt-5">Acceso a la base de datos</h1>
	
	<?php
	if (!isset($_REQUEST['entrar'])) {
		$usuario="";
		imprimirFormulario($usuario);
	}
	else {
		$usuario=recoge("usuario");
		$password=recoge("password");
		
		$errores="";
		
		if ($usuario=="") {
			$errores=$errores."<li>El campo usuario no puede estar vacío</li>";
		}
		if ($password=="") {
			$errores=$errores."<li>El campo contraseña no puede estar vacío</li>";
		}
		
		if ($errores!="") {
			echo "<h2>Errores:</h2> <ul>$errores</ul>";
			imprimirFormulario($usuario);
		}
		else {
			$usu=seleccionarUsuario($usuario);
			if (empty($usu)) {
				echo "<div class='alert alert-danger' role='alert'>hola no son correctos</div>";
				imprimirFormulario($usuario);
			}
			else {
				$hash=$usu['password'];
				if (password_verify($password, $hash)) {
					$_SESSION["nombre"]=$usuario;
					header("Location: menu.php");
				} else {
					echo "<div class='alert alert-danger' role='alert'> adios no son correctos</div>";
					imprimirFormulario($usuario);
				}
			}
		}
	}
	?>
	
</main>

<?php require_once "inc/pie.php"; ?>