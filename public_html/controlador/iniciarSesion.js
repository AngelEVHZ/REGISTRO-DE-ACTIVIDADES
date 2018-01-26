/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function iniciarSesion(){
    var nombre= $("#nombre").val();
    var contra= $("#contrasena").val();
    
    maestro = true;
    if(maestro)
        location.href ="maestro.html";
    else
        location.href ="tutor.html";
    
    
}

function salir(){
   
        location.href ="index.html";

    
    
}
