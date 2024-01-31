// Fetch para cargar las publicaciones de un usuario
async function getPublisByUser(){
	const response = await fetch('model/api/publisbyuser.php');
	const data = await response.json();
	return data
}

getPublisByUser().then(publicaciones => {
	if (publicaciones.length == 0) {
		// Si el usuario no tiene publicaciones mostrarmos el boton para agregar publicaciones
		document.querySelector('.hidden').setAttribute('style','display:block;');
	}
	publicaciones.forEach(publi => {
		// Creamos la publicacion
		createPubli(publi)
	})
})

// Funcion para agregar publicaciones
// info->Informacion de publicaciones
function createPubli(info){

	// Instanciamos el template
	const tpl = publi.content
	const clon = tpl.cloneNode(true);
	
	// Cargamos la imagen
	clon.querySelector(".img_publi").setAttribute("src", info.img);

	// Cargamos el contenido
	clon.querySelector(".content").innerHTML = info.content
	// Cargamos la fecha
	clon.querySelector(".fecha").innerHTML = info.fechaPubli;

	// Cargamos el id de la publicacion
	clon.querySelector(".btn-edit").setAttribute('id','publi_'+info.id_publicacion);

	// Cargamos la funcion para mostrar la ventana para editar la publicacion
	clon.querySelector('.btn-edit').setAttribute('onclick','windowEditPubli('+info.id_publicacion+')')
	// Cargamos la funcion para cerrar la ventana para editar la publicacion
	clon.querySelector('.close-btn-edit').setAttribute('onclick','closeWindowEditPubli('+info.id_publicacion+')')
	// Cargamos la id a la ventana para editar la publicacion
	clon.querySelector('.window_edit_publi').setAttribute('id', 'win_publi_'+info.id_publicacion);
	// Cargamos el titulo
	clon.querySelector('.icon_info').textContent = info.title

	// Cargamos la id de la publicacion
	clon.querySelector('.form_id_publi').value = info.id_publicacion;
	// Cargamos el titulo de la publicacion
	clon.querySelector('.title_edit_publi').value = info.title;
	// Cargamos el contenido de la publicacion
	clon.querySelector('.content_edit_publi').textContent = info.content;

	// Cargamos la publicacion al listado
	publis.appendChild(clon);
}

// Funcion para mostrar la ventana para agregar publicaciones
function windowPubli() {
	window_publi.setAttribute('style','height: calc(100vh - 80px);')
}

// Funcion para cerrar la ventana para agregar publcaciones
function closeWindowPubli(){
	window_publi.setAttribute('style','height: 0;')
}

// Funcion para mostrar la ventana para editar publcaciones
function windowEditPubli(id_publi) {
	console.log(id_publi)
	document.querySelector('#win_publi_'+id_publi).setAttribute('style','top: 0;')
}

// Funcion para cerrar la ventana para editar publcaciones
function closeWindowEditPubli(id_publi){
	document.querySelector('#win_publi_'+id_publi).setAttribute('style','top: 401px;')
}

// Funcion para mostrar la ventana para eliminar publcaciones
function windowDeleteUser () {
	window_delete_user.setAttribute('style','height: 200%; width: 100%;')
	document.body.style.overflow = 'hidden';
}

// Funcion para cerrar la ventana para eliminar publcaciones
function closeWindowDelete () {
	window_delete_user.setAttribute('style','height: 0; width: 0;')
	document.body.style.overflow = 'scroll';
}

if (alert_check.content != '') {
	// si la alerta tiene contenido, la mostramos
	alert_check.setAttribute('style','height: 50px;')
	setInterval(function() {alert_check.setAttribute('style','height: 0; padding: 0px;')}, 5000)
}
