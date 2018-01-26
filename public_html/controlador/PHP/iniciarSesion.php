<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$nombre=$_POST['nombre'];
$contra=$_POST['contra'];


$query = "SELECT * FROM maestro WHERE nombre = ? AND contrasena = ?";
$pre = $conn->prepare($query);
$pre->bind_param("ss", $nombre,$contra);
$pre->execute();

$datos = $pre->get_result();
$echo = array("validar","id");

if( $datos->num_rows>0){
    $echo[0]= "1";
    $datos = $datos->fetch_array(MYSQLI_ASSOC);
    $echo[1]= $datos["idmaestro"];
    
}else{
    $echo[0]= "0";
}
    
 echo json_encode($echo);
     
		
$conn->close();
?>