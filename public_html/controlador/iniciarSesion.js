/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function iniciarSesion(){
    var nombre= $("#nombre").val();
    var contra= $("#contrasena").val();
    

    $.ajax({
		url: "../controlador/PHP/iniciarSesion.php",
		data: {nombre:nombre,contra:contra},
		type: "POST",
		datatype: "text",
		beforeSend: function (xhr) {
		},
		success: function (respuesta) {
			 contenido = JSON.parse(respuesta);
                        if(contenido[0] == "1"){
                             sessionStorage.setItem("idMaestro", contenido[1]);
                             location.href ="maestro.html";
                        }
		},
		error: function (jqXHR, textStatus) {
		}
	});
   
    
}

function salir(){
   
        location.href ="index.html";

    
    
}
