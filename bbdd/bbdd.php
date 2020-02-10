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
?>
