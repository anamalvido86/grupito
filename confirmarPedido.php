<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="confirmarPedido";
	  $titulo="Confirmo de pedido";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<main role="main">

<?php
	if (!isset($_SESSION["carrito"])) {
		header("Location:index.php");
	}
	if (!isset($_SESSION["usuario"])) {
		header("Location:login.php");
	}
	$email=$_SESSION['email'];
	
	$usuario=seleccionarUsuario($email);
	$idUsuario=$usuario['idUsuario'];
	$detallePedido=$_SESSION['carrito'];
	$total=$_SESSION['total'];

	$idPedido=InsertarPedido ($idUsuario, $detallePedido, $total);

	if ($idPedido!=0) {
		echo "<div class='alert alert-success' role='alert'> Su pedido $idPedido ha sido realizado correctamente </div>";
		echo "<p><a href='index.php' class='btn btn-primary'>Volver a la pagina principal</a></p>";
		unset($_SESSION['carrito']);
		unset($_SESSION['total']);
	} 
	else {
		echo '<div class="alert alert-danger" role="alert"> ERROR: Pedido no insertado </div>';
		echo "<p><a href='carrito.php' class='btn btn-primary'>Volver al carrito</a></p>";
	}
?>

</main>

<?php require_once("inc/pie.php"); ?>