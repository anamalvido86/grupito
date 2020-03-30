<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="index";
	  $titulo="Mi grupito";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<?php
	$productos=seleccionarOfertasPortada (NUMOFERTAS);
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Bienvenido a Mi Grupito!</h1>
      <p >La tienda con las mejores ofertas de internet que podrás compartir con tu amigos.</p>
      <p><a class="btn btn-info btn-lg" href="productos.php" role="button">Nuestras ofertas »</a></p>
    </div>
  </div>

  <div class="container">
  <?php
	mostrarProductos($productos);
	print_r($_SESSION);
  ?>

    <hr>

  </div> <!-- /container -->

</main>

<?php require_once("inc/pie.php"); ?>