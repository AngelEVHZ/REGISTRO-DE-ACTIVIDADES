


<?php

require 'CONEXION.php';
$db = new CONEXION();
$conn = $db->getConnection();

$id=$_POST['idMateria'];
$idA=$_POST['idAlumno'];
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


$query = "SELECT * FROM alumno as a, alumnos_inscritos as ai WHERE ai.materia_idmateria = ? and ai.alumno_idalumno = a.idalumno and a.idalumno = ?";
$pre = $conn->prepare($query);
$pre->bind_param("ii",$id,$idA);
$pre->execute();
$datos = $pre->get_result();


$echo[0].="<thead>
              <tr>
    
                ". $echo[1]."
                <th>TOTAL</th>
                <th>Aprobado</th>   
                                
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
                $caliTotal=0;
                $aprobrado="SI";
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
                    
                    if($recu==null || $recu==0 ){
                        $caliTotal+=intval($cali);
                         if($cali<$calMin)$aprobrado="NO";
                    }else{
                        $caliTotal+=intval($recu);
                        if($recu<$calMin)$aprobrado="NO";
                    }
                    
                    /****************/
                    if(intval($cali) < intval($calMin) && !$primera){
                         $echo[2].="<td>".$cali.""
                                 . "<br>Recuperacion<br>".$recu."</td>";
                         $tipoCLas=1;
                    }else{
                        $echo[2].="<td>".$cali."</td>";
                    }
                    
                }
                if($numeroActividades>0)
                    $caliTotal/=$numeroActividades;
                else
                    $caliTotal=100;
                
                if($aprobrado=="SI")
                    $echo[0].="<tr class='success' >";
                else
                     $echo[0].="<tr class='danger' >";
                
               
       

                $echo[0].=$echo[2]."<td >".intval($caliTotal)."</td><td>".$aprobrado."  </td>
                </tr>";
              
    }
}   
$echo[0].=" </tbody> ";

echo json_encode($echo);
$conn->close();  
		

?>