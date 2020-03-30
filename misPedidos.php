<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="misPedidos";
	  $titulo="Mis pedidos";
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
      <h1 class="display-3">Mis pedidos</h1>
    </div>
  </div>

   <?php
	$email=$_SESSION['email'];
	$usuario=seleccionarUsuario($email);
	$idUsuario=$usuario['idUsuario'];
	
	$pedidos=seleccionarPedidosUsuario($idUsuario);
	if (empty($pedidos)) {
		$mensaje="No tienes ningún pedido";
		mostrarMensaje($mensaje);
	}
	else {
	
  ?>
  <div class="container">
		<div class="row px-5">
			<table class="table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">Pedido</th>
				  <th scope="col" class="text-center">Fecha</th>
				  <th scope="col" class="text-center">Total</th>
				   <th scope="col" class="text-center">Estado</th>
				   <th></th>
				</tr>
			  </thead>
			  <tbody>
				<?php
					foreach ($pedidos as $pedido) {
						$idPedido=$pedido['idPedido'];
						$fecha=$pedido['fecha'];
						$total=$pedido['total'];
						$estado=$pedido['estado'];
				?>
						<tr>
						  <th scope="row"> <?php echo "$idPedido"; ?> </th>
						  <td class="text-center"><?php echo "$fecha"; ?></td>
						  <td class="text-center"><?php echo "$total"; ?></td>
						  <td class="text-center"><?php echo "$estado"; ?></td>
						  <td><a href="detallePedido.php?id=<?php echo "$idPedido"; ?>" class="text-info">Ver detalle</a></td>
						</tr>
				<?php
					}
				?>
			  </tbody>
			</table>
		</div>
	</div>
	<?php
	}
	?>
</main>

<?php require_once("inc/pie.php"); ?>