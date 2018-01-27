

<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['idmateria'];
$corte=$_POST['corte'];
$calMin=$_POST['calMin'];



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
$tipoCLas=0;
if( $datos->num_rows>0){
    while($cont = $datos->fetch_array(MYSQLI_ASSOC)){
       $idalimno =$cont["idalumno"];
        $tipoCLas=0;
                $echo[2]="";
                for($i=0;$i<$numeroActividades;$i++){
                     /************** obtener las calificaciones*/
                    $query3 = "SELECT * FROM calificaciones  WHERE alumno_idalumno = ? AND materia_idmateria=? AND actividad_idactividad=?";
                    $pre3 = $conn->prepare($query3);
                    $pre3->bind_param("iii",$idalimno,$id,$idactividades[$i]);
                    $pre3->execute();
                    $datos3 = $pre3->get_result();
                    $row = $datos3->fetch_array(MYSQLI_ASSOC);
                    $primera=false;
                    $cali =$row["calificacion"];
                    $recu =$row["recuperacion"];
                    if($cali==null){$cali=0;$primera=true;}
                    if($recu==null)$recu=0;
                    /****************/
                    if(intval($cali) < intval($calMin) && !$primera){
                         $echo[2].="<td><input type='number' value=".$cali." class='form-control' style = 'width:80px;'  oninput='cambiarClase(".$idalimno.")' id='inputcal".$idalimno."act".$idactividades[$i]."'  >"
                                 . "Recuperacion<input type='number' value=".$recu." class='form-control' style = 'width:80px;'  oninput='cambiarClase(".$idalimno.")' id='inputrecu".$idalimno."act".$idactividades[$i]."'  ></td>";
                         $tipoCLas=1;
                    }else{
                        $echo[2].="<td><input type='number' value=".$cali." class='form-control' style = 'width:80px;'  oninput='cambiarClase(".$idalimno.")' id='inputcal".$idalimno."act".$idactividades[$i]."'  ></td>";
                    }
                    
                }

                
                $echo[0].="<tr class='success' id='tr".$idalimno."'>";
                $echo[0].="<td>".$cont["matricula"]."</td>
                            <td>".$cont["nombre"]."</td>";
       

                $echo[0].=$echo[2]."<td></td><td> <button class='btn btn-warning navbar-btn' onclick='actualizar(".$idalimno.",".json_encode($idactividades).")'>Actualizar</button></td>
                </tr>";
              
    }
}   
$echo[0].=" </tbody> ";

echo json_encode($echo);
$conn->close();  
		

?>