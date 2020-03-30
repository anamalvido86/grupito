<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="login";
	  $titulo="Identifícate";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

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
		<p><a href="registro.php" class="text-dark"> ¿No tienes cuenta? Regístrate</a></p>
		<button type="submit" class="btn btn-info" name="entrar" value="entrar">Entrar</button>
	</form>
<?php
}
?>

<?php
	if (isset($_SESSION['usuario'])) {
		header('Location:index.php');
	}
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
		<h1 class="display-3">Identifícate</h1>
		<p >
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
					$errores=$errores."<li>El campo password no puede estar vacío</li>";
				}
					
				if ($errores!="") {
					echo "<h2>Errores:</h2> <ul>$errores</ul>";
					imprimirFormulario($usuario);
				}
				else {
					$usu=seleccionarUsuario($usuario);
					if (empty($usu)) {
						echo "<div class='alert alert-danger' role='alert'> El usuario o contraseña no son correctos</div>";
							imprimirFormulario($usuario);
					}
					else {
						$hash=$usu['password'];
						if (password_verify($password, $hash)) {
							if ($usu['online']==TRUE) {
								$_SESSION['email']=$usu["email"];
								$_SESSION['usuario']=$usu["nombre"];
								header("Location: index.php");
							}
							else {
								echo "<div class='alert alert-danger' role='alert'> El usuario está desactivado</div>";
							imprimirFormulario($usuario);
							}
						} else {
							echo "<div class='alert alert-danger' role='alert'> El usuario o contraseña no son correctos</div>";
							imprimirFormulario($usuario);
						}
					}
				}
			}
		?>
		</p>
    </div>
  </div>
</main>

<?php require_once("inc/pie.php"); ?>