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
$pre->execute();


$limite=1;
$query2 = "SELECT * FROM actividad ORDER BY actividad.idactividad DESC limit ?";
$pre2 = $conn->prepare($query2);
$pre2->bind_param("i",$limite);
$pre2->execute();
$datos = $pre2->get_result();
$datos =$datos->fetch_array(MYSQLI_ASSOC);
$idactividad=$datos["idactividad"];


$query2 = "SELECT * FROM alumno as a, alumnos_inscritos as ai WHERE ai.materia_idmateria = ? and ai.alumno_idalumno = a.idalumno";
$pre2 = $conn->prepare($query2);
$pre2->bind_param("i",$idmateria);
$pre2->execute();
$datos = $pre2->get_result();
if( $datos->num_rows>0){
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
        $idalumno =$cont["idalumno"];
         
        $query = "INSERT INTO calificaciones (alumno_idalumno,materia_idmateria,actividad_idactividad) VALUES (?,?,?)";
        $pre = $conn->prepare($query);
        $pre->bind_param("iii",$idalumno,$idmateria,$idactividad);
        $pre->execute();

    }
 }

echo"1";



$conn->close();  
		

?>