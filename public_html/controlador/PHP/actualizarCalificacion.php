<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$idalumno=$_POST['idalumno'];
$idmateria=$_POST['idmateria'];
$idactividad=$_POST['idactividad'];
$calificacion=$_POST['calificacion'];
$recu=$_POST['recuperacion'];




$query = "UPDATE calificaciones SET calificacion = ? , recuperacion = ? WHERE alumno_idalumno =? AND materia_idmateria =? AND actividad_idactividad =?";
$pre = $conn->prepare($query);
$pre->bind_param("iiiii",$calificacion,$recu,$idalumno,$idmateria,$idactividad);
echo $pre->execute();




$conn->close();  
		

?>