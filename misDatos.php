<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="misDatos";
	  $titulo="Mis datos";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<?php
	if (!isset($_SESSION['usuario'])) {
		header('Location:index.php');
	}
?>
<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Mis datos</h1>
      <p><a class="btn btn-info btn-lg" href="modificarDatos.php" role="button">Modificar datos</a>
	  <a class="btn btn-info btn-lg" href="cambiarContraseña.php" role="button">Cambiar contraseña</a></p>
    </div>
  </div>

  <div class="container">
	<?php
		$email=$_SESSION['email'];
		$usuario=seleccionarUsuario($email);
		
		$email=$usuario['email'];
		$nombre=$usuario['nombre'];
		$apellidos=$usuario['apellidos'];
		$direccion=$usuario['direccion'];
		$telefono=$usuario['telefono'];
		
	?>
		<dl class="row">
		  <dt class="col-sm-3">Nombre</dt>
		  <dd class="col-sm-9"><?php echo $nombre; ?></dd>

		  <dt class="col-sm-3">Apellidos</dt>
		  <dd class="col-sm-9"><?php echo $apellidos; ?></dd>

		  <dt class="col-sm-3">Email</dt>
		  <dd class="col-sm-9"><?php echo $email; ?></dd>

		  <dt class="col-sm-3">Telefono</dt>
		  <dd class="col-sm-9"><?php echo $telefono; ?></dd>

		  <dt class="col-sm-3">Dirección</dt>
		  <dd class="col-sm-9"><address><?php echo $direccion; ?></address></dd>
		</dl>
  </div> <!-- /container -->

</main>

<?php require_once("inc/pie.php"); ?>