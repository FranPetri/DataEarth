// Sidebar ---------------------------------------

// Funcion para abrir el menu
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

// Funcion para cerrar el menu
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}

// Funcion para mostrar la ventana para registrarse como socio
function windowRegister() {
  document.querySelector('.win_register').style.height = '300px';
}

// Funcion para cerrar la ventana para registrarse como socio
function closeWindow(){
  document.querySelector('.win_register').style.height = '0';
}