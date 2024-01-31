// Fetch para tomar los datos de las plantas
async function getPlants(){
	const response = await fetch('model/api/bibloteca.php');
	const data = await response.json();
	return data;
}

getPlants().then(data => {
	data.forEach(planta => {
		if (document.querySelector('#listado') != null) {			
			// console.log('Planta validada Cargada')
			createPlantCard(planta)
		}
		if (document.querySelector('#listado_no_valid') != null) {
			// console.log('Planta no validada no Cargada')
			createPlantCardValidate(planta)
		}
	})
})

function createPlantCard(info){
	if (info.validate == 0) {
		return false;
	}
	console.log(info)
	const tpl = plantCard.content
	const clon = tpl.cloneNode(true)

	clon.querySelector('.plant_validate').setAttribute('class','valid_'+info.validate)

	clon.querySelector('.img_plant').setAttribute('src',info.img_plant)
	clon.querySelector('.name_plant').textContent = info.name

	listado.appendChild(clon)
}

function createPlantCardValidate(info){
	if (info.validate == 1) {
		return false;
	}
	const tpl = plantCard.content
	const clon = tpl.cloneNode(true)

	clon.querySelector('.plant_validate').setAttribute('class','valid_'+info.validate)
	clon.querySelector('.plant_id').setAttribute('value',info.id)

	clon.querySelector('.img_plant').setAttribute('src',info.img_plant)
	clon.querySelector('.name_plant').textContent = info.name

	listado_no_valid.appendChild(clon)
}


function windowPlant(){
	window_publi.setAttribute('style','height: calc(100vh - 80px);')	
}

function closeWindowPubli(){
	window_publi.setAttribute('style','height: 0;')
}