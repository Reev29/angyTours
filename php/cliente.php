<?php 
$cliente = $_POST['cliente'];
// $conexion = new mysqli('servidor','usuario','password','basedatos',3306);
$conexion = new mysqli('localhost','Agencia','angytours','ava',3306);
$consulta = "SELECT `NombreIDViajero,IDVIajero FROM cliente WHERE Nombre = '$cliente";
$result = $conexion->query($consulta);
 
$respuesta = new stdClass();
if($result->num_rows > 0){
    $fila = $result->fetch_array();
    $respuesta->IDViajero = $fila['NombreIDViajero'];
    $respuesta->idV = $fila['idViajero'];
    // $respuesta->materno = $fila['materno'];
}
echo json_encode($respuesta);
 ?>

  