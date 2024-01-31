// Instanciamos el nombre del usuario
let user = user_name.textContent

// Fetch para las imagenes del usuario
async function getImagesByUser(){
	const response = await fetch('model/api/perfil.php?user='+user);
	const data = await response.json();
	return data
}

getImagesByUser().then(data => {
	// Cargamos las imagenes del usuario
	data.forEach(info => {
		if (info.avatar != "") {
			// Si se encuentra el avatar de usuario, lo carga
			document.querySelector('.avatar').setAttribute('src',info.avatar)
		}
		if (info.banner != "") {
			// Si se encuentra el banner de usuario, lo carga
			document.querySelector('.banner').setAttribute('src',info.banner)
		}
	})
})