

<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['idmateria'];
$corte=$_POST['corte'];

$query = "SELECT a.nombre, a.matricula FROM alumno as a, alumnos_inscritos as ai WHERE ai.materia_idmateria = ? and ai.alumno_idalumno = a.idalumno";
$pre = $conn->prepare($query);
$pre->bind_param("i",$id);
$pre->execute();
$datos = $pre->get_result();
$echo = array();
$echo[0]="";
$echo[0].="<thead>
              <tr>
                <th>Matricula</th>
                <th>Nombre</th>
                <th>TOTAL</th>    
              </tr>
            </thead>";

$echo[0].=" <tbody> ";
if( $datos->num_rows>0){
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
        
       $echo[0].="<tr class='success'>
                <td>".$cont["matricula"]."</td>
                <td>".$cont["nombre"]."</td>
                <td></td>
              </tr>";
              
    }
}   
$echo[0].=" </tbody> ";

echo json_encode($echo);
$conn->close();  
		

?>