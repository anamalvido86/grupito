<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>



<main role="main" class="container">


		<h1 class="mt-5">Listado de usuarios</h1>
	
	<p><a href="insertarUsuario.php" class="btn btn-success">Nuevo usuario</a></p>
	
	<?php
		$usuarios=seleccionarTodosUsuarios();
		$numTareas=count($usuarios);
		
		$usuariosPagina=2;
		$paginas=ceil($numTareas/$usuariosPagina);
		
		$pagina=recoge('pagina');
		if ($pagina==false or $pagina<=0 or $pagina>$paginas) {
			$pagina=1;
		}
		$inicio=($pagina-1)*$usuariosPagina;
		
		$usuarios=seleccionarUsuarioPagina($inicio, $usuariosPagina);
	?>
	
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">Usuario</th>
					<th scope="col">Email</th>
					<th scope="col">Nombre</th>
					<th scope="col">Apellidos</th>
					<th scope="col">Dirección</th>
					<th scope="col">Teléfono</th>
					<th scope="col">Online</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				foreach ($usuarios as $user) {
					$usuario=$user['idUsuario'];
					$email=$user['email'];
					$nombre=$user['nombre'];
					$apellidos=$user['apellidos'];
					$direccion=$user['direccion'];
					$telefono=$user['telefono'];
					$online=$user['online'];

				?>
				
					<tr>
						<th scope="row"><?php echo "$usuario"; ?></th>
						<td><?php echo "$email"; ?></td>
						<td><?php echo "$nombre"; ?></td>
						<td><?php echo "$apellidos"; ?></td>
						<td><?php echo "$direccion"; ?></td>
						<td><?php echo "$telefono"; ?></td>
						<td><?php echo "$online"; ?></td>
						<td><a href="actualizarUsuario.php?usuario=<?php echo "$usuario"; ?>" class="btn btn-info">Editar</a> 
						<a href="cambiarContraseña.php?usuario=<?php echo "$usuario"; ?>" class="btn btn-dark">Cambiar Contraseña</a> 
							<a href="borrarUsuario.php?usuario=<?php echo "$usuario"; ?>" onClick="return Confirmar('¿Realmente quieres borrar el usuario?');" class="btn btn-danger">Borrar</a></td>
							
					</tr>
					
				<?php
				}	//Fin foreach tareas
				echo "<p><a href='menu.php' class='btn btn-primary'>Volver al menú principal</a></p>";
				?>

	
			
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item <?php if ($pagina==1){echo 'disabled';} ?>"><a class="page-link" href="gestionarUsuarios.php?pagina=<?php echo $pagina-1; ?>">Anterior</a></li>
				<?php
					for ($i=1;$i<=$paginas;$i++) {
				?>
					<li class="page-item <?php if ($i==$pagina){echo 'active';} ?>"><a class="page-link" href="gestionarUsuarios.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php
					}
				?>
				<li class="page-item <?php if ($pagina==$paginas){echo 'disabled';} ?>"><a class="page-link" href="gestionarUsuarios.php?pagina=<?php echo $pagina+1; ?>">Siguiente</a></li>
			</ul>
		</nav>
		

</main>

<script>
	function Confirmar(Mensaje){
		return (confirm(Mensaje))?true:false;
	}
</script>
<?php require_once "inc/pie.php"; ?>