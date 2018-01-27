

<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['idmateria'];
$corte=$_POST['corte'];


$echo = array();
$echo[0]="";
$echo[1]="";

// recuperar actividades
$query = "SELECT * FROM actividad as a where a.materia_idmateria = ? and a.corte=?";
$pre = $conn->prepare($query);
$pre->bind_param("ii",$id,$corte);
$pre->execute();
$datos = $pre->get_result();
$numeroActividades=0;
$idactividades = array();

if( $datos->num_rows>0){
    $numeroActividades=$datos->num_rows;
    $j=0;
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
        
       $echo[1].="<th>".$cont["nombre"]."</th>";
       $idactividades[$j] =$cont["idactividad"];
       $j++;
              
    }
} 


$query = "SELECT * FROM alumno as a, alumnos_inscritos as ai WHERE ai.materia_idmateria = ? and ai.alumno_idalumno = a.idalumno";
$pre = $conn->prepare($query);
$pre->bind_param("i",$id);
$pre->execute();
$datos = $pre->get_result();


$echo[0].="<thead>
              <tr>
                <th>Matricula</th>
                <th>Nombre</th>
                ". $echo[1]."
                <th>TOTAL</th>    
                <th>Actualizar</th>                  
              </tr>
            </thead>";

$echo[0].=" <tbody> ";
$j=0;
if( $datos->num_rows>0){
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
       $idalimno =$cont["idalumno"];
        
       $echo[0].="<tr class='success' id='tr".$idalimno."'>
                <td>".$cont["matricula"]."</td>
                <td>".$cont["nombre"]."</td>";
       
       
       
                $echo[2]="";
                for($i=0;$i<$numeroActividades;$i++){$echo[2].="<td><input type='number' class='form-control'  oninput='cambiarClase(".$idalimno.")' id='inputcal".$idalimno."act".$idactividades[$i]."'  ></td>";}
       
                
                
                
                
                $echo[0].=$echo[2]."<td></td><td> <button class='btn btn-warning navbar-btn' onclick='actualizar(".$idalimno.",".json_encode($idactividades).")'>Actualizar</button></td>
              </tr>";
              
    }
}   
$echo[0].=" </tbody> ";

echo json_encode($echo);
$conn->close();  
		

?>