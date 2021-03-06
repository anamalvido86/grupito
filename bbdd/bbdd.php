<?php include "configuracion.php"; ?>

<?php
//Función para conectarnos a la BD
function conectarBD() {
	try{
		$con= new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", USER, PASS);
	
		$con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo "Error: Error al conectar la BD: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}
	
	return $con;
}

//Funcion para desconectar BD 
function desconectarBD($con) {
	$con= NULL;
	return $con;
}

function seleccionarOfertasPortada ($numOfertas) {
	$con=conectarBD();
	try {
		$sql ="SELECT * FROM productos LIMIT :numOfertas";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':numOfertas', $numOfertas, PDO::PARAM_INT); //Cuando necesite un valor entero hay que ponerlo
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar ofertas: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
}

function seleccionarTodasOfertas () {
	$con=conectarBD();
	try {
		$sql ="SELECT * FROM productos";
		$stmt=$con->prepare($sql);
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar ofertas: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
}

//Funcion para seleccionar un producto
function seleccionarProducto($idProducto) {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM productos WHERE idProducto=:idProducto";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);  //Como maximo cuando solo devuelve una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar una oferta: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $row;
}

//Funcion para seleccionar usuario
function seleccionarUsuario($email) {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM usuarios WHERE email=:email";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);  //Como maximo cuando solo devuelve una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar un usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $row;
}
//Funcion para insertar usuario
function insertarUsuario($email, $password, $nombre, $apellidos, $direccion, $telefono) {
	$con=conectarBD();
	$password=password_hash($password, PASSWORD_DEFAULT);
	try {
		$sql="INSERT INTO usuarios(email, password, nombre, apellidos, direccion, telefono) VALUES (:email, :password, :nombre, :apellidos, :direccion, :telefono)";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellidos', $apellidos);
		$stmt->bindParam(':direccion', $direccion);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al insertar usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}
	return $stmt->rowCount();
}

//Funcion Insertar pedido
function InsertarPedido ($idUsuario, $detallePedido, $total) {
	$conexion=conectarBD();
	try{
		$conexion->beginTransaction();
		$sql="INSERT INTO pedidos(idUsuario, total) VALUES (:idUsuario, :total)";
		$sentencia=$conexion->prepare($sql);
		$sentencia->bindParam(':idUsuario', $idUsuario);
		$sentencia->bindParam(':total', $total);
		$sentencia->execute();
		
		$idPedido=$conexion->lastInsertId();
		foreach ($detallePedido as $idProducto=>$cantidad) {
			$producto= seleccionarProducto($idProducto);
			$precio=$producto['precioOferta'];
			$sql2="INSERT INTO detallePedido(idPedido, idProducto, cantidad, precio) VALUES (:idPedido, :idProducto, :cantidad, :precio)";
			$sentencia=$conexion->prepare($sql2);
			$sentencia->bindParam(':idPedido', $idPedido);
			$sentencia->bindParam(':idProducto', $idProducto);
			$sentencia->bindParam(':cantidad', $cantidad);
			$sentencia->bindParam(':precio', $precio);
			$sentencia->execute();
		}
		$conexion->commit();
	}
	catch (PDOException $e) {
		$conexion->rollback();
		echo "Error: Error al insertar un pedido: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $idPedido;
}

//Funcion para actualizar usuarios
function actualizarUsuario($email, $nombre, $apellidos, $direccion, $telefono) {
	$con=conectarBD();
	try{
		$sql= "UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, direccion=:direccion, telefono=:telefono WHERE email=:email";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellidos', $apellidos);
		$stmt->bindParam(':direccion', $direccion);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al actualizar usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $stmt->rowCount();
}

//Funcion para actualizar contraseña usuarios
function actualizarContraseña($email, $password) {
	$con=conectarBD();
	$password=password_hash($password, PASSWORD_DEFAULT);
	try{
		$sql= "UPDATE usuarios SET password=:password WHERE email=:email";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al actualizar usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $stmt->rowCount();
}

//Funcion selecccionar todos los pedidos de un usuario
function seleccionarPedidosUsuario ($idUsuario) {
	$con=conectarBD();
	try {
		$sql ="SELECT * FROM pedidos WHERE idUsuario=:idUsuario";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idUsuario', $idUsuario);
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar pedidos de un usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
}

//Funcion selecccionar un pedido
function seleccionarPedido ($idPedido) {
	$con=conectarBD();
	try {
		$sql ="SELECT * FROM pedidos WHERE idPedido=:idPedido";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idPedido', $idPedido);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);  //Como maximo cuando solo devuelve una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar un pedido: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $row;
}

//Funcion selecccionar todos los detalles de un pedido
function seleccionarDetallePedido($idPedido) {
	$con=conectarBD();
	try {
		$sql ="SELECT * FROM detallePedido WHERE idPedido=:idPedido";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idPedido', $idPedido);
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar los detalles de un pedido: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
}
?>
