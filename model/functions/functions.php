<?php 
	// Inculimos la Base de Datos y sus funciones
	include 'model/db/dbTools.php';

	// Funcion para trabajar con los templates de Views
	// $arch->Archivo HTML
	function getComponents($arch){
		if (file_exists('views/templates/components/'.$arch.'.html')) {
			// Si encuentra el archivo retornar su contenido
			return file_get_contents('views/templates/components/'.$arch.'.html');			
		}
		// Si no encuentra el archivo retorna False
		return false;
	}

	// Funcion para registrar el Chip de los Usuarios
	// $user->Usuario, $chipid->Id del Chip, $apodo->Apodo de Chip
	function registerChip($user,$chipid,$apodo){
		// Query para modificar el ChipId del usuario
		query("UPDATE `usuarios` SET `chip_id`='$chipid' WHERE `nick` = '$user' ",true);
		// Registra el sensor con su Id, Usuario y Apodo
		query("INSERT INTO `sensor` (`chipid`,`user`,`apodo`) VALUES ('$chipid','$user','$apodo')",true);
		return true; 
	}

	// Funcion para crear publicaciones
	// $user->Usuario, $title->Titulo de la Publicacion, $image->Imagen de la Publicacion, $content->Contenido de la Publicacion
	function createPubli($user,$title,$image,$content){
		// Instanciamos la fecha
		$date = date('Ymd_H');
		// Instanciamos un numero random
		$rand_num = rand();
		// Explode de $image
		$img_txt = explode('.',$image['name']);
		// Instanciamos la imagen con su Usuario, Fecha, Numero y Tipo
		$img_txt = $user.'_'.$date.'_'.$rand_num.'.'.$img_txt[1];

		if (!validateImage($image)) {
			// Si la imagen no es valida retorna False
			return false;
		}

		if (move_uploaded_file($image['tmp_name'], 'resources/publis_users/'.$user.'/'.$img_txt)) {
			// Si la imagen se sube correctamente, instanciar la direccion de la misma y realizar la query a la base de datos
			$dir_image = 'resources/publis_users/'.$user.'/'.$img_txt;
			query("INSERT INTO `publicaciones` (`title`,`user`,`content`,`img`) VALUES ('$title','$user','$content','$dir_image')",true);
			return true;
		}
	}

	// Funcion para editar publicaciones
	// $id_publi->Id de la publicacion, $title->Titulo, $content->Contenido de la imagen
	function editPubli($id_publi,$title,$content){
		// Realizamos la query con los parametros 
		$publi = query("UPDATE `publicaciones` SET `title`='$title',`content`='$content' WHERE `id_publicacion` = '$id_publi'",true);
		if (!$publi) {
			// Si la publicacion no se ha subido retorna False
			return false;
		}
		// Si publicacion se subio retorna True
		return true;
	}

	// Funcion para borrar publcaciones
	// $id_publi->Id Publicacion
	function deletePubli($id_publi){
		// Eliminamos de la base de datos la publicacion
		$publi = query("DELETE FROM `publicaciones` WHERE `id_publicacion` = '$id_publi'",true);
		if (!$publi) {
			// Si no se ha borrado retorna False
			return false;
		}
		// Si se ha borrado retorna True
		return true;
	}

	// Funcion para validar imagenes
	// $image->Array de la Imagen
	function validateImage($image){
		if (!((strpos($image['type'],'png')) || strpos($image['type'],'jpg') || strpos($image['type'],'jpeg'))) {
			// Si el tipo de imagen no corresponde a PNG, JPG o JPEG retorna False
			return false;
		}
		if ($image['size'] >= 100000 ) {
			// Si la imagen pesa mas de 1MB
			return false;
		}
		// Si el tipo y peso es correcto retorna True
		return true;		
	}

	// Funcion para agregar plantas
	// $user->Usuario, $name->Nombre de la Planta, $image->Imagen de la Planta
	function addPlant($user,$name,$image){
		if (!validateImage($image)) {
			// Si la imagen no es valida retorna False
			return false;
		}
		// Instanciamos la fecha
		$date = date('Ymd_H');
		// Explode de $image
		$img_txt = explode('.',$image['name']);
		// Instanciamos el nombre de la imagen con su tipo
		$img_txt = $name.'.'.$img_txt[1];

		if (move_uploaded_file($image['tmp_name'], 'resources/img/plants/'.$img_txt)) {
			// Si la imagen se ha subido correctamente se instancia la direccion, se sube a la base de datos y retorna True
			$dir_image = 'resources/img/plants/'.$img_txt;
			query("INSERT INTO `plantas` (`name`, `img_plant`, `user_include`) VALUES ('$name','$dir_image','$user')",true);
			return true;
		}
	}
 ?>