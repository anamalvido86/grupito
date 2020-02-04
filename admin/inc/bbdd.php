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

//Funcion para insertar producto
function insertarProducto($nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online) {
	$con=conectarBD();
	try {
		$sql="INSERT INTO productos(nombre, introDescripcion, descripcion, imagen, precio, precioOferta, online) VALUES (:nombre, :introDescripcion, :descripcion, :imagen, :precio, :precioOferta, :online)";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':introDescripcion', $introDescripcion);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':imagen', $imagen);
		$stmt->bindParam(':precio', $precio);
		$stmt->bindParam(':precioOferta', $precioOferta);
		$stmt->bindParam(':online', $online);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al insertar producto: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}
	return $con->lastInsertId();
}

//Funcion para actualizar producto
function actualizarProducto($idProducto, $nombre, $introDescripcion, $descripcion, $imagen, $precio, $precioOferta, $online) {
	$con=conectarBD();
	try{
		$sql= "UPDATE productos SET nombre=:nombre, introDescripcion=:introDescripcion, descripcion=:descripcion, imagen=:imagen, precio=:precio, precioOferta=:precioOferta, online=:online WHERE idProducto=:idProducto";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idProducto', $idProducto);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':introDescripcion', $introDescripcion);
		$stmt->bindParam(':descripcion', $descripcion);
		$stmt->bindParam(':imagen', $imagen);
		$stmt->bindParam(':precio', $precio);
		$stmt->bindParam(':precioOferta', $precioOferta);
		$stmt->bindParam(':online', $online);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al actualizar producto: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $stmt->rowCount();
}

//Funcion para borrar productos
function borrarProducto($idProducto){
	$con=conectarBD();
	try{
		$sql= "UPDATE productos SET online=0 WHERE idProducto=:idProducto";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idProducto', $idProducto);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al eliminar producto: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $stmt->rowCount();
}

//Funcion seleccionar todas las productos
function seleccionarTodosProductos() {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM productos";
		$stmt=$con->query($sql);
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar todos los productos: ".$e->getMessage();
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
		$stmt->bindParam(':idProducto', $idProducto);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);  //Como maximo cuando solo devuelve una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar un producto: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $row;
}

//Funcion para seleccionar productos por pagina
function seleccionarProductoPagina($inicio, $pagina) {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM productos LIMIT :inicio, :pagina";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT); //Cuando necesite un valor entero hay que ponerlo
		$stmt->bindParam(':pagina', $pagina, PDO::PARAM_INT);
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar productos: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
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

//Funcion para actualizar usuarios
function actualizarUsuario($email, $password, $nombre, $apellidos, $direccion, $telefono) {
	$con=conectarBD();
	$password=password_hash($password, PASSWORD_DEFAULT);
	try{
		$sql= "UPDATE usuarios SET email=:email, password=:password, nombre=:nombre, apellidos=:apellidos, direccion=:direccion, telefono=:telefono WHERE idUsuario=:idUsuario";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idUsuario', $idUsuario);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
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

//Funcion para borrar usuarios
function borrarUsuario($idUsuario){
	$con=conectarBD();
	try{
		$sql= "DELETE FROM usuarios WHERE idUsuario=:idUsuario";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':idUsuario', $idUsuario);
		$stmt->execute();
	}
	catch (PDOException $e) {
		echo "Error: Error al eliminar usuario: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $stmt->rowCount();
}

//Funcion seleccionar todas los usuarios
function seleccionarTodosUsuarios() {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM usuarios";
		$stmt=$con->query($sql);
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar todas los usuarios: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
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

//Funcion para seleccionar usuarios por pagina
function seleccionarUsuarioPagina($inicio, $pagina) {
	$con=conectarBD();
	try{
		$sql= "SELECT * FROM usuarios LIMIT :inicio, :pagina";
		$stmt=$con->prepare($sql);
		$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT); //Cuando necesite un valor entero hay que ponerlo
		$stmt->bindParam(':pagina', $pagina, PDO::PARAM_INT);
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_ASSOC); //Cuando devuelve o puede devolver mas de una fila
	}
	catch (PDOException $e) {
		echo "Error: Error al seleccionar usuarios: ".$e->getMessage();
		file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
		exit;
	}	
	return $rows;
}
?>