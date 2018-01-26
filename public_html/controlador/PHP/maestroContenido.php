<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['id'];

$query = "SELECT m.nombre, m.idmateria FROM materia as m, maestro_materia as ma WHERE ma.maestro_idmaestro = ? and ma.materia_idmateria = m.idmateria";
$pre = $conn->prepare($query);
$pre->bind_param("i",$id);
$pre->execute();
$datos = $pre->get_result();
$echo = array();
$echo[0]="";

if( $datos->num_rows>0){
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
        $echo[0].="<option value=".$cont["idmateria"].">".$cont["nombre"]."</option>";
    }
}    
echo json_encode($echo);
$conn->close();  
		

?>