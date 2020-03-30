<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>



<main role="main" class="container">

<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:index.php");
	}
?>
		<h1 class="mt-5">Detalle del pedido</h1>
	
<?php
	$idPedido=recoge('idPedido');
	if ($idPedido=="") {
		header("Location:misPedidos.php");
	}
	
	$pedido=seleccionarPedido($idPedido);
	
	$fecha=$pedido['fecha'];
	$estado=$pedido['estado'];
	$total=$pedido['total'];
	$idUsuario=$pedido['idUsuario'];
	
	$usuario=seleccionarUsuarioId($idUsuario);
	$nombre=$usuario['nombre'];
	$apellidos=$usuario['apellidos'];
	$email=$usuario['email'];
	$direccion=$usuario['direccion'];
	$telefono=$usuario['telefono'];
	
	$detallePedido=seleccionarDetallePedido($idPedido);
  ?>
  <div class="container">
		<div class="row px-5">
			<h3>Datos del usuario:</h3>
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
			
			
			
			<dl class="row">
			  <dt class="col-sm-3">Nº Pedido</dt>
			  <dd class="col-sm-9"><?php echo $idPedido; ?></dd>
			  
			  <dt class="col-sm-3">Fecha</dt>
			  <dd class="col-sm-9"><?php echo $fecha; ?></dd>

			  <dt class="col-sm-3">Estado</dt>
			  <dd class="col-sm-9"><?php echo $estado; ?></dd>
				
			</dl>
			
			
			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">Producto</th>
				  <th scope="col" class="text-center">Cantidad</th>
				  <th scope="col" class="text-center">Precio</th>
				   <th scope="col" class="text-center">Subtotal</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
					foreach ($detallePedido as $detalle) {
						$idProducto=$detalle['idProducto'];
						$producto=seleccionarProducto($idProducto);
						$nombre=$producto['nombre'];
						
						$cantidad=$detalle['cantidad'];
						$precio=$detalle['precio'];
						$subtotal=$precio*$cantidad;
				?>
						<tr>
						  <th scope="row"> <?php echo "$nombre"; ?></th>
						  <td class="text-center"> <?php echo "$cantidad"; ?> </td>
						  <td class="text-center"><?php echo "$precio"; ?></td>
						  <td class="text-center"><?php echo "$subtotal"; ?></td>
						</tr>
				<?php
					}
				?>
			  </tbody>
			  <tfoot>
				<tr>
					<th scope="row" colspan="3" class="text-right">Total</th>
					<td class="text-center"><?php echo "$total"; ?></td>
				</tr>
			  </tfoot>
			</table>
			
		</div>
	</div>
	<p><a href='gestionarPedidos.php' class='btn btn-primary'>Volver a los pedidos</a></p>
</main>
<?php require_once "inc/pie.php"; ?>