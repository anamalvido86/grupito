<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="misDatos";
	  $titulo="Mis datos";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Mis datos</h1>
      <p><a class="btn btn-info btn-lg" href="editarDatos.php" role="button">Editar</a></p>
    </div>
  </div>

  <div class="container">


  </div> <!-- /container -->

</main>

<?php require_once("inc/pie.php"); ?>