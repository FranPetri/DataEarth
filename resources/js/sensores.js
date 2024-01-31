const getData = async () => {
	const data = await fetch('model/api/plants.php'); //
	const result = await data.json();
	return result;
}

document.addEventListener("DOMContentLoaded", () => {
	refreshDatos();
	refreshId = setInterval(refreshDatos, 3000)
})

function refreshDatos(){
	getData().then(data => {
		data.forEach(plants => {

		let hume_amb_stat = document.querySelector("#hume_amb_stat")
		let plant_hume_amb = plants.hume_amb
		hume_amb_stat.innerHTML = (plant_hume_amb+"%")


		let tmp_amb_stat = document.querySelector("#tmp_amb_stat")
		let plant_tmp_amb = plants.tmp_amb
		tmp_amb_stat.innerHTML = (plant_tmp_amb+"°C")
		

		let hume_ter_stat = document.querySelector("#hume_ter_stat")
		let plant_hume_ter = plants.hume_ter
		hume_ter_stat.innerHTML = (plant_hume_ter+"%")
		
		let luz_stat_stat = document.querySelector("#luz_stat_stat")
		let plant_luz_stat = plants.luz_stat
		luz_stat_stat.innerHTML = (plant_luz_stat+"%")

		});
	})
}

const fechas = [];
const tmp_amb = [];
const hume_amb = [];
const hume_ter = [];
const luz = [];


const getDatabyCant = async (cant) => {
	const data = await fetch('model/api/plants.php?cant='+cant);
	const result = await data.json();
	return result;
}

getDatabyCant(3).then(data => {
	data.forEach(info => {

		// Ambiental
		tmp_amb.push(info.tmp_amb)
		hume_amb.push(info.hume_amb)

		// Terrenal
		hume_ter.push(info.hume_ter)	

		// Luz
		luz.push(info.luz_stat)

		let hora = ''

		fecha = info.fechaHora.split(' ')
		horas = fecha[1].split(':')
		hora = hora.concat(horas[0],':',horas[1])
		fechas.push(hora)
	})
	fechas.sort()

	const data_tmp = {
		labels: fechas,
		datasets: [{
					label: 'Temperatura Ambiental',
					borderColor: '#344D67',
					backgroundColor: '#F3ECB0',
					data: tmp_amb,
				}]
	}
	renderChart('myChartTmp_Amb',data_tmp,'Ambiental')

	const data_hume = {
		labels: fechas,
		datasets: [{
					label: 'Humedad Ambiental',
					borderColor: '#344D67',
					backgroundColor: '#F3ECB0',
					data: hume_amb,
				}]
	}
	renderChart('myChartHume_Amb',data_hume,'Ambiental')

	const data_ter = {
		labels: fechas,
		datasets: [{
					label: 'Humedad Terrenal',
					borderColor: '#F3ECB0',
					backgroundColor: '#ADE792',
					data: hume_ter,
				}]
	}
	renderChart('myChartHume_Ter',data_ter,'Terrenal')

	const data_luz = {
		labels: fechas,
		datasets: [{
					label: 'Luz',
					borderColor: '#344D67',
					backgroundColor: '#F3ECB0',
					data: luz,
				}]
	}
	renderChart('myChartLuz',data_luz,'Luz')
})


function renderChart(canva,info_data,titulo){
	const ctx = document.querySelector('#'+canva);
	// console.log(info_data)
	let options = {}

	if (titulo === 'Ambiental') {
		options = {
			indexAxis: 'x',
			scales: {
					// Porcentajes
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true,
		                    fontColor: '#4a5663',
		                },
		            }],
		            // Labels X (Horas)
		         	xAxes: [{
		                ticks: {
		                    fontColor: '#4a5663'
		                },
		            }],
		        } ,
				legend: {
					display: false,
					position: 'top',
					labels: {
						padding: 5,
						boxWidth: 40,
						fontFamily: 'system-ui',
						fontColor: 'white',
					}
				},
				// Cartel de mensaje
				tooltips: {
					backgroundColor: '#4a5663',
					titleFontSize: 20,
					xPadding: 20,
					yPadding: 20,
					mode: 'index', 
				},
				elements: {
					// Linea
					line: {
						borderWidth: 4,
						fill: false,
					},
					// Punto de Dato
					point: {
						radius: 10,
						borderWidth: 4,
						backgroundColor: '#6ECCAF',
						hoverRadius: 8,
						hoverRadiusWidth: 4,	
					}
				},
				animation: {
					duration: 0
				},
				responsiveAnimationDuration: 0,
				responsive: true,
				maintainAspectRatio: false
		}
	}

	if (titulo === 'Terrenal') {
		options = {
			indexAxis: 'x',
			scales: {
					// Porcentajes
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true,
		                    fontColor: '#F3ECB0',
		                },
		            }],
		            // Labels X (Horas)
		         	xAxes: [{
		                ticks: {
		                    fontColor: '#F3ECB0'
		                },
		            }],
		        } ,
				legend: {
					display: false,
					position: 'top',
					labels: {
						padding: 5,
						boxWidth: 40,
						fontFamily: 'system-ui',
						fontColor: 'white',
					}
				},
				// Cartel de mensaje
				tooltips: {
					backgroundColor: '#ADE792',
					titleFontSize: 20,
					xPadding: 20,
					yPadding: 20,
					mode: 'index', 
				},
				elements: {
					// Linea
					line: {
						borderWidth: 4,
						fill: false,
					},
					// Punto de Dato
					point: {
						radius: 10,
						borderWidth: 4,
						backgroundColor: '#6ECCAF',
						hoverRadius: 8,
						hoverRadiusWidth: 4,	
					}
				},
				animation: {
					duration: 0
				},
				responsiveAnimationDuration: 0,
				responsive: true,
				maintainAspectRatio: false
		}	
	}

	if (titulo === 'Luz') {
		// console.log(titulo)
		options = {
			indexAxis: 'x',
			scales: {
					// Porcentajes
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true,
		                    fontColor: '#F3ECB0',
		                },
		            }],
		            // Labels X (Horas)
		         	xAxes: [{
		                ticks: {
		                    fontColor: '#F3ECB0'
		                },
		            }],
		        } ,
				legend: {
					display: false,
					position: 'top',
					labels: {
						padding: 5,
						boxWidth: 40,
						fontFamily: 'system-ui',
						fontColor: 'white',
					}
				},
				// Cartel de mensaje
				tooltips: {
					backgroundColor: '#344D67',
					titleFontSize: 20,
					xPadding: 20,
					yPadding: 20,
					mode: 'index', 
				},
				elements: {
					// Linea
					line: {
						borderWidth: 4,
						fill: false,
					},
					// Punto de Dato
					point: {
						radius: 10,
						borderWidth: 4,
						backgroundColor: '#6ECCAF',
						hoverRadius: 8,
						hoverRadiusWidth: 4,	
					}
				},
				animation: {
					duration: 0
				},
				responsiveAnimationDuration: 0,
				responsive: true,
				maintainAspectRatio: false
			}	
	}

	const config = {
		type: 'line',
		data: info_data,
		options: options
	}


	// if (canva != null) {
	// 	 myChartTmp_Amb.destroy();
	// }

	canva = new Chart(ctx,config)
}

function ambientalWin(){
	document.querySelector('.footer').setAttribute('style','position:sticky;')
	ambiental_panel.classList.add('h60')
	btn_ambiental.setAttribute('onclick','ambientalClose()')
}

function ambientalClose(){
	ambiental_panel.classList.remove('h60')
	btn_ambiental.setAttribute('onclick','ambientalWin()')
}

function terrenalWin(){
	document.querySelector('.footer').setAttribute('style','position:sticky;')
	terrenal_panel.classList.add('h60')
	btn_terrenal.setAttribute('onclick','terrenalClose()')
}

function terrenalClose(){
	terrenal_panel.classList.remove('h60')
	btn_terrenal.setAttribute('onclick','terrenalWin()')
}

function luzWin(){
	document.querySelector('.footer').setAttribute('style','position:sticky;')
	luz_panel.classList.add('h60')
	btn_luz.setAttribute('onclick','luzClose()')
}

function luzClose(){
	document.querySelector('.footer').setAttribute('style','position:absolute;')
	luz_panel.classList.remove('h60')
	btn_luz.setAttribute('onclick','luzWin()')
}