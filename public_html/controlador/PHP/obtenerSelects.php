<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['id'];
$tipo=$_POST['tipo'];

switch ($tipo){

    case "alumno":
        $query = "SELECT nombre, idalumno,matricula FROM alumno JOIN tutorados on alumno.idalumno = tutorados.alumno_idalumno WHERE tutorados.maestro_idmaestro = ?";
        $pre = $conn->prepare($query);
        $pre->bind_param("i",$id);
        $pre->execute();
        $datos = $pre->get_result();

        if( $datos->num_rows>0){
            while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
                echo"<option value=".$cont["idalumno"].">".$cont["nombre"]."</option>";
            }
        }    
    break;
    case "materia":
         $query = " SELECT * FROM materia join alumnos_inscritos on alumnos_inscritos.materia_idmateria = idmateria WHERE alumnos_inscritos.alumno_idalumno = ?";
        $pre = $conn->prepare($query);
        $pre->bind_param("i",$id);
        $pre->execute();
        $datos = $pre->get_result();

        if( $datos->num_rows>0){
            while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
                echo"<option value=".$cont["idmateria"].">".$cont["nombre"]."</option>";
            }
        }    
            
    break;


            }
$conn->close();  
		

?>