/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var calMin=70;

$( document ).ready(function() {
    cargarContenido(); 
    
});

function cambiarClase(id){
    
    $("#tr"+id).removeClass("success");
    $("#tr"+id).removeClass("danger");

}



function actualizar(idalumno, idactividad){
    var tipo = $("#td"+idalumno).val();
    
    var ultimo=0;
    var id;
    var id2;
    var calificacion=0;
    var recuperacion=0;
    
    idmateria= $("#materia").val();
    for(var i =0;i<idactividad.length;i++){
       id="#inputcal"+idalumno+"act"+idactividad[i];
       id2="#inputrecu"+idalumno+"act"+idactividad[i];
           calificacion=$(id).val();
           recuperacion=$(id2).val();
           if(!recuperacion)recuperacion=null;
   
            $.ajax({
		url: "../controlador/PHP/actualizarCalificacion.php",
		data: {idalumno:idalumno,idactividad:idactividad[i],idmateria:idmateria,calificacion:calificacion,recuperacion:recuperacion},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                        ultimo+=1;
                        if(ultimo==idactividad.length){
                            if(tipo=="SI")
                                $("#tr"+idalumno).addClass("success");
                            else
                                $("#tr"+idalumno).addClass("danger");
                        }
                    
                    
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
    }
    
  
}

function irTutorias(){
     sessionStorage.setItem("idMaestro", sessionStorage.getItem("idMaestro"));
     location.href ="tutor.html";
  
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
		data: {corte:corte,idmateria:idmateria,calMin:calMin},
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

 