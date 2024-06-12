<?php
include_once("../../Modelo/php/BD.php");
session_start();
// obtenerHistorial($_POST["usuario"]);
$usuario = $_POST["usuario"];
$conexion = new BD("bonAppetit", "admin", "1234");
// $sql = "SELECT * FROM pedidos WHERE fk_usuario = (SELECT id FROM usuarios WHERE nombre = '$usuario')";
$sql = "SELECT pedidos.fecha, estados.descripcion, pedidos.observaciones, pedidos.fk_usuario,pedidos.id FROM pedidos JOIN estados ON pedidos.fk_estado = estados.id WHERE pedidos.fk_usuario = (SELECT id FROM usuarios WHERE nombre = '$usuario') ORDER BY pedidos.fecha DESC";
//DESCOMENTAR LA SIGUIENTE LINEA SI SE TIENEN PEDIDOS EN LAS ULTIMAS 3 SEMANAS
// -- AND fecha >= DATE_SUB(CURDATE(), INTERVAL 3 WEEK)";
$pedidos = array();
$resultado = $conexion->realizarConsulta($sql);
while ($fila = $resultado->fetch()) {
    $pedido = [
        "fecha" => $fila["fecha"],
        "estado" => $fila["descripcion"],
        "observaciones" => $fila["observaciones"],
        "numeroPedido" => $fila["id"],
    ];
    array_push($pedidos, $pedido);
}
echo json_encode($pedidos, JSON_UNESCAPED_UNICODE);
unset($conexion);
