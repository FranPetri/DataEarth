// Al cargar el DOM se instancia la pagina de las publicaciones como uno y se cargan las publicaciones
document.addEventListener('DOMContentLoaded', (element) => {
	let page = 1;
	refreshPage();	
})

let page = 1;
pages.innerHTML = page;

// Al hacer click en el boton ">" suma una pagina y cargan las publicaciones
btn__next.addEventListener("click", e => {
	page++;
	refreshPage();
})	

// Al hacer click en el boton ">" resta una pagina y cargan las publicaciones
btn__previus.addEventListener("click", e => {
	if(page>1)
		page--;
	refreshPage();	
})

// Funcion para cargar las publicaciones en la pagina
function refreshPage(){
	// Instanciamos las paginas
	pages.innerHTML = page;
	// Instanciamos el listado vacio para reiniciar el contenido del mismo
	listado.innerHTML = "";

	// Fetch para tomar las publicaciones en orden por fecha descendiente
	getPublisPerDay().then(publicaciones => {
		if (publicaciones.length == 0) {
			// Si no se encuentran publicaciones
			// No mostrar el boton ">"
			btn__next.setAttribute('style','display:none;')
			// Ocultamos la opcion para agregar una publicacion
			document.querySelector('.btn-add').setAttribute('style','display: none;')
			listado.setAttribute('style','flex-direction: column; ')
			listado.setAttribute('style','height: 80%;')
			// Se muestra un mensaje y un boton para agregar publicaciones
			listado.innerHTML = '<div class="dflex fdc jcspa aic h100p "> <h1 class="tango color_yellow fs20 tac">¡ NO HAY MAS PUBLCACIONES !</h1><button onclick="windowPubli()" class="btn-publi tommy_medium color_blue fs20 bornone back_green br3 pd15">Añadir nueva publicacion</button></div>'
		}
		if (publicaciones.length <= 3) {
			// Estilo del listado
			listado.setAttribute('style','height: 75%;')
		}
		publicaciones.forEach(publi => {
			// Al encontrar pubicaciones se muestra el boton ">"
			btn__next.setAttribute('style','display:block;')
			// Se muestra el boton para agregar publicaciones
			document.querySelector('.btn-add').setAttribute('style','display: block;')
			listado.setAttribute('style','height: 75%;')
			// Creamos la publicacion
			createPubli(publi)		
		})
	})
}

// Funcion para mostrar la ventana de publicaciones de un usuario
// user->Usuario
function windowUserPublis(user){
	// Mostramos la ventana
	document.querySelector('.window_user').setAttribute('style','height: calc(100vh - 80px);');
	// Reiniciamos el contenido
	document.querySelector('.list_publis_user').innerHTML = "";
	getImagesByUser(user).then(data => {
		// Incluimos la informacion del usuario
		data.forEach(info => {
			if (info.avatar != "") {
				// Si el usuario tiene un avatar, lo carga
				avatar_user.setAttribute('src',info.avatar)
			}else{
				// Si el usuario no tiene avatar, carga el default
				avatar_user.setAttribute('src','resources/img/logo/logo.svg')
			}
			if (info.banner != "") {
				// Si el usuario tiene un banner, lo carga
				banner_user.setAttribute('src',info.banner)
			}else{
				// Si el usuario no tiene banner, carga el default
				banner_user.setAttribute('src','resources/img/plants/aloevera.jpg')
			}
		})
	})
	getPublisByUserWindow(user).then(publicaciones => {
		publicaciones.forEach(publi => {
			// Cargamos las publicaciones del usuario que se pasa por parametro
			userPublis(publi)
		})
	})
}

// Funcion para cargar las publcaciones del usuario
// info->Informacion de la publicacion
function userPublis(info){
	// Instanciamos el nombre del usuario
	document.querySelector('.user_publis').innerHTML = info.user

	// Cargamos el template
	const tpl = user_publis.content
	const clon = tpl.cloneNode(true);

	// Cargamos la imagen
	clon.querySelector(".img_publi_user").setAttribute("src", info.img);
	// Cargamos el contenido
	clon.querySelector(".content_user").innerHTML = info.content
	// Cargamos la fecha
	clon.querySelector(".fecha_user").innerHTML = info.fechaPubli;
	// Cargamos el titulo
	clon.querySelector('.icon_info_user').textContent = info.title

	// Añadimos la publicacion al listado
	document.querySelector('.list_publis_user').appendChild(clon);
}

// Funcion para cerrar la ventana de publicaciones del usuario
function closeWindowUserPublis(){
	document.querySelector('.window_user').setAttribute('style','height: 0;')
	// avatar_user.setAttribute('src','resources/img/logo/logo.svg');
}

// Funcion para crear publicaciones
// info->Informacion de la publicacion
function createPubli(info){
	// Cargamos el template
	const tpl = publi.content
	const clon = tpl.cloneNode(true);

	// Cargamos la imagen
	clon.querySelector(".img_publi").setAttribute("src", info.img);
	// Cargamos el nombre del usuario
	clon.querySelector(".user").innerHTML = info.user;
	// Cargamos la funcion para ver las publicaciones del usuario
	clon.querySelector('.user').setAttribute('onclick', "windowUserPublis('"+info.user+"')"); 

	// Cargamos el contenido
	clon.querySelector(".content").innerHTML = info.content
	// Cargamos la fecha
	clon.querySelector(".fecha").innerHTML = info.fechaPubli;

	// Añadimos la publicacion al listado
	listado.appendChild(clon);
}

// FETCHS --------------------------------------
// Fetch para las publicaciones de un usuario
async function getPublisByUserWindow(user){
	const response = await fetch('model/api/publicaciones.php?user='+user);
	const data = await response.json();
	return data;
}
// Fetch para las publicaciones de un usuario en su perfil
async function getImagesByUser(user){
	const response = await fetch('model/api/perfil.php?user='+user);
	const data = await response.json();
	return data
}
// Fetch para las publicaciones en orden descendiente por la fecha
async function getPublisPerDay(){
	const response = await fetch('model/api/publicaciones.php?page='+page);
	const data = await response.json();
	return data
}

// Funcion para mostrar la ventana para agregar publicaciones
function windowPubli() {
	window_publi.setAttribute('style','height: calc(100vh - 80px); width: calc(100vw - 30vw); margin-left: 15vw;');
}
// Funcion para cerrar la ventana para agregar publicaciones
function closeWindowPubli(){
	window_publi.setAttribute('style','height: 0;')
}