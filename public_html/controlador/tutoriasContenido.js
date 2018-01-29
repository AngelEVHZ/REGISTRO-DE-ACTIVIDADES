/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var calMin=70;
function irMaestro(){
     sessionStorage.setItem("idMaestro", sessionStorage.getItem("idMaestro"));
     location.href ="maestro.html";
  
}


$( document ).ready(function() {
    llenarAlumnos();
   
});

function llenarAlumnos(){
    idMaestro = sessionStorage.getItem("idMaestro");
    var tipo = "alumno";
     $.ajax({
		url: "../controlador/PHP/obtenerSelects.php",
		data: {id:idMaestro,tipo:tipo},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                     $('#alumnos').empty();
                     $('#alumnos').append( respuesta ); 
                     llenarMateria();
                    
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
    
    
}
function llenarMateria(){
    idAlumno= $("#alumnos").val();
    var tipo = "materia";
    $.ajax({
		url: "../controlador/PHP/obtenerSelects.php",
		data: {id:idAlumno,tipo:tipo},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                    
                     $('#materia').empty();
                     $('#materia').append( respuesta ); 
                     cargarTabla();
                    
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
    
    
    
}

function cargarTabla(){
    idAlumno= $("#alumnos").val();
    corte= 1;
    idMateria= $("#materia").val();
    
     $.ajax({
		url: "../controlador/PHP/tutoradoTabla.php",
		data: {idMateria:idMateria,idAlumno:idAlumno,corte:corte,calMin:calMin},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                    var contenido = JSON.parse(respuesta);
                         $('#table').empty();
                         $('#table').append( contenido[0] );
                   
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
         corte= 2;
         $.ajax({
		url: "../controlador/PHP/tutoradoTabla.php",
		data: {idMateria:idMateria,idAlumno:idAlumno,corte:corte,calMin:calMin},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                     var contenido = JSON.parse(respuesta);
                         $('#2table').empty();
                         $('#2table').append( contenido[0] );
                   
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
         corte= 3;
         $.ajax({
		url: "../controlador/PHP/tutoradoTabla.php",
		data: {idMateria:idMateria,idAlumno:idAlumno,corte:corte,calMin:calMin},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
                    var  contenido = JSON.parse(respuesta);
                         $('#3table').empty();
                         $('#3table').append( contenido[0] );
                   
		},
		error: function (jqXHR, textStatus) {
                    alert("error");
		}
	});
    
    
    
}