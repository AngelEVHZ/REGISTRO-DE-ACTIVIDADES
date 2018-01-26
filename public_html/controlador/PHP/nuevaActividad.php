<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$idmateria=$_POST['idmateria'];
$corte=$_POST['corte'];
$nombre=$_POST['nombre'];

$query = "INSERT INTO actividad (nombre,materia_idmateria,corte) VALUES (?,?,?)";
$pre = $conn->prepare($query);
$pre->bind_param("sii",$nombre,$idmateria,$corte);
echo $pre->execute();


$conn->close();  
		

?>