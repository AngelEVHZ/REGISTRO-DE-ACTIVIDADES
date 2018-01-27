/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready(function() {
    cargarContenido(); 
    
});

function cambiarClase(id){
    $("#tr"+id).removeClass("success");
    $("#tr"+id).addClass("danger");
}

function actualizar(idalumno, idactividad){
    var id;
    var calificacion=0;
    for(var i =0;i<idactividad.length;i++){
       id="#inputcal"+idalumno+"act"+idactividad[i];
           calificacion=$(id).val();
           console.log(calificacion);
    }
    cargarTabla();
  
}


function cargarContenido(){
    id = sessionStorage.getItem("idMaestro");
    if(id==null){
        location.href ="index.html";
    }
   
     $.ajax({
		url: "../controlador/PHP/maestroContenido.php",
		data: {id:id},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
			 contenido = JSON.parse(respuesta);
                         $('#materia').empty();
                         $('#materia').append( contenido[0] );
                         cargarTabla();
                       
		},
		error: function (jqXHR, textStatus) {
		}
	});
    
}



function cargarTabla(){
   corte= $("#corteMateria").val();
    idmateria= $("#materia").val();
     $.ajax({
		url: "../controlador/PHP/cargarTabla.php",
		data: {corte:corte,idmateria:idmateria},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
			 contenido = JSON.parse(respuesta);
                         $('#table').empty();
                         $('#table').append( contenido[0] );
                       
		},
		error: function (jqXHR, textStatus) {
		}
	});
    
   
    
}


function nuevaActividad(){
     idmateria= $("#materia").val();
     corte= $("#actividadCorte").val();
     nombre= $("#actividadNombre").val();
   
     $.ajax({
		url: "../controlador/PHP/nuevaActividad.php",
		data: {idmateria:idmateria,corte:corte,nombre:nombre},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                 
			if(respuesta=="1"){
                             cargarTabla();
                             
                        }
                       
		},
		error: function (jqXHR, textStatus) {
		}
	});
    
}

 