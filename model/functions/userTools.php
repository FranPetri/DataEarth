<?php 
	// Funciones
	include 'model/functions/functions.php';

	// Funcion para registrar el usuario
	// $nick->Nombre del Usuario, $email->Email del Usuario, $pass->Contraseña del Usuario
	function registerUser($nick,$email,$pass){
		if (query("SELECT * FROM `usuarios` WHERE `nick` = '$nick'",true)) {
			// Si el nombre del usuario ya se encuentra en la base de datos retorna 1
			return 1;
		}
		if (query("SELECT * FROM `usuarios` WHERE `email` = '$email'",true)) {
			// Si el email del usuario ya se encuentra en la base de datos retorna 2
			return 2;
		}
		
		// Creamos la carpeta del usuario
		shell_exec('mkdir resources/publis_users/'.$nick);
		
		// Creamos la carpeta para las fotos de perfil del usuario
		shell_exec('mkdir resources/publis_users/'.$nick.'/profile');
		
		// Instanciamos el avatar y banner por predefinidas del usuario
		shell_exec('cp resources/img/plants/aloevera.jpg resources/publis_users/'.$nick.'/profile/banner_'.$nick.'.jpg');
		shell_exec('cp resources/img/logo/logo.svg resources/publis_users/'.$nick.'/profile/avatar_'.$nick.'.svg');

		// Direccion del Avatar
		$avatar_dir = 'resources/publis_users/'.$nick.'/profile/avatar_'.$nick.'.svg';
		// Direccion del Banner
		$banner_dir = 'resources/publis_users/'.$nick.'/profile/banner_'.$nick.'.jpg';

		// Encriptamos la contraseña del usuario
		$pass = md5($pass);

		// Realizamos la query para registrar el usuario
		query("INSERT INTO `usuarios`(`email`,`nick`, `pass`,`avatar`,`banner`) VALUES ('$email','$nick','$pass','$avatar_dir','$banner_dir')",true);
		// Si todo es correcto se retorna 3
		return 3;
	}

	// Funcion para validar el usuario
	function validateUser($user,$pass){
		// Encriptamos la contraseña que ingreso el usuario
		$pass = md5($pass);
		// Realizamos la query para encontrar el usuario
		$query_user = query("SELECT * FROM `usuarios` WHERE `nick` = '$user' AND `pass` = '$pass'",true);
		
		if ($query_user == null || $query_user[0]['nick'] != $user) {
			// Si no se encuentra el usuario retorna False
			return false;
		}
		// Si se encuentra el usuario retorna True
		return true;
	}

	// Funcion para eliminar usuarios
	// $user-> Usuario
	function deleteUser($user){
		// Realizamos para query para eliminar el usuario de la base de datos
		$query_user = query("DELETE FROM `usuarios` WHERE `nick` = '$user'",true);
		// Eliminamos la carpeta del usuario
		shell_exec('rm -r resources/publis_users/'.$user);
		// Realizamos para query para eliminar las publicaciones del usuario de la base de datos
		$query_publis = query("DELETE FROM `publicaciones` WHERE `user` = '$user'",true);
		// Retornamos True
		return true;
	}

	// Funcion para editar el usuario
	// $user->Usuario, $new_nick->Nuevo nombre, $avatar->Nuevo avatar, $banner-> Nuevo banner
	function editUser($user,$new_nick,$avatar,$banner){

		// Si no cargo se le informara ------------------------------------------------------------------------
		if ($new_nick == "" && $avatar['size'] == 0 && $banner['size'] == 0) {
			// Retorna False
			return false;				
		}

		// Si solo cargo un nuevo apodo -------------------------------------------------------
		if ($new_nick != "" && $avatar['size'] == 0 && $banner['size'] == 0) {
			// Cambiamos el nombre del usuario en la tabla Usuarios, Sensor y Publicaciones
			query("UPDATE `usuarios` SET `nick`='$new_nick' WHERE `nick` = '$user'",true);	
			query("UPDATE `sensor` SET `user`='$new_nick' WHERE `user` = '$user'",true);
			query("UPDATE `publicaciones` SET `user`='$new_nick' WHERE `user` = '$user'",true);
			
			// Cambiamos las direcciones de las publicaciones, avatar y banner
			changeDirPublis($new_nick);
			changeBanner($new_nick);
			changeAvatar($new_nick);
			
			// Cambiamos el nombre de la carpeta
			shell_exec('mv resources/publis_users/'.$user.' resources/publis_users/'.$new_nick);
			return true;
		}

		// Si cargo un nuevo apodo y avatar ---------------------------------------------------
		if ($new_nick != "" && $avatar['size'] != 0 && $banner['size'] == 0) {
			if (!validateImage($avatar)) {
				// Si la imagen no es valida retornamos 3
				return 3;
			}
			// Cambiamos la direccion de la imagen
			updateImage($user,'avatar',$avatar);

			// Cambiamos el nombre del usuario en la tabla Usuarios, Sensor y Publicaciones
			query("UPDATE `usuarios` SET `nick`='$new_nick' WHERE `nick` = '$user'",true);
			query("UPDATE `sensor` SET `user`='$new_nick' WHERE `user` = '$user'",true);
			query("UPDATE `publicaciones` SET `user`='$new_nick' WHERE `user` = '$user'",true);
					
			// Cambiamos las direcciones de las publicaciones, avatar y banner
			changeDirPublis($new_nick);
			changeBanner($new_nick);
			changeAvatar($new_nick);

			// Cambiamos el nombre de la carpeta
			shell_exec('mv resources/publis_users/'.$user.' resources/publis_users/'.$new_nick);
			return true;
		}

		// Si cargo un nuevo apodo y banner ---------------------------------------------------
		if ($new_nick != "" && $avatar['size'] == 0 && $banner['size'] != 0) {
			if (!validateImage($banner)) {
				// Si la imagen no es valida retornamos 3
				return 3;
			}
			// Cambiamos la direccion de la imagen
			updateImage($user,'banner',$banner);

			// Cambiamos el nombre del usuario en la tabla Usuarios, Sensor y Publicaciones
			query("UPDATE `usuarios` SET `nick`='$new_nick' WHERE `nick` = '$user'",true);
			query("UPDATE `sensor` SET `user`='$new_nick' WHERE `user` = '$user'",true);
			query("UPDATE `publicaciones` SET `user`='$new_nick' WHERE `user` = '$user'",true);
					
			// Cambiamos las direcciones de las publicaciones, avatar y banner
			changeDirPublis($new_nick);
			changeBanner($new_nick);
			changeAvatar($new_nick);
			
			// Cambiamos el nombre de la carpeta
			shell_exec('mv resources/publis_users/'.$user.' resources/publis_users/'.$new_nick);
			return true;
		}

		// Si cargo todo nuevo ----------------------------------------------------------------
		if ($new_nick != "" && $avatar['size'] != 0 && $banner['size'] != 0) {
			if (!validateImage($banner) || !validateImage($avatar)) {
				return 3;
			}
			// Cambiamos la direccion del avatar y el banner
			updateImage($user,'avatar',$avatar);
			updateImage($user,'banner',$banner);
			
			// Cambiamos el nombre del usuario en la tabla Usuarios, Sensor y Publicaciones
			query("UPDATE `usuarios` SET `nick`='$new_nick' WHERE `nick` = '$user'",true);
			query("UPDATE `sensor` SET `user`='$new_nick' WHERE `user` = '$user'",true);
			query("UPDATE `publicaciones` SET `user`='$new_nick' WHERE `user` = '$user'",true);
					
			// Cambiamos las direcciones de las publicaciones, avatar y banner
			changeDirPublis($new_nick);
			changeBanner($new_nick);
			changeAvatar($new_nick);
			
			// Cambiamos el nombre de la carpeta
			shell_exec('mv resources/publis_users/'.$user.' resources/publis_users/'.$new_nick);
			return true;
		}

		// Si solo cargo un nuevo avatar ------------------------------------------------------
		if ($new_nick == "" && $avatar['size'] != 0 && $banner['size'] == 0) {
			if (!validateImage($avatar)) {
				// Si la imagen no es valida retorna 3
				return 3;
			}
			// Cambiamos la direccion del avatar
			updateImage($user,'avatar',$avatar);
			return true;
		}

		// Si solo cargo un nuevo banner ------------------------------------------------------
		if ($new_nick == "" && $avatar['size'] == 0 && $banner['size'] != 0) {
			if (!validateImage($banner)) {
				// Si la imagen no es valida retorna 3
				return 3;
			}
			// Cambiamos la direccion del banner
			updateImage($user,'banner',$banner);
			return true;
		}

		// Si cargo un nuevo banner y avatar --------------------------------------------------
		if ($new_nick == "" && $avatar['size'] != 0 && $banner['size'] != 0) {
			if (!validateImage($avatar)) {
				// Si la imagen no es valida retorna 3
				return 3;
			}
			if (!validateImage($banner)) {
				// Si la imagen no es valida retorna 3
				return 3;
			}
			// Cambiamos la direccion del avatar y el banner
			updateImage($user,'avatar',$avatar);
			updateImage($user,'banner',$banner);
			return true;
		}
	}

	// Funcion para cambiar el nombre del usuario en la direccion de las publicaciones en la base de datos
	// $new_nick->Nuevo nombre
	function changeDirPublis($new_nick){
		// Buscamos la direccion con el nuevo nombre
		$images_dir = query("SELECT `id_publicacion`,`img` FROM `publicaciones` WHERE `user` = '$new_nick'",true);
		// Cambiamos todas las publicaciones que encontremos en la base de datos 
		foreach ($images_dir as $key => $value) {
			// Explode de la direccion de la imagen
			$new_dir = explode('/', $value['img']);
			// Asignamos el nuevo nombre
			$new_dir[2] = $new_nick;
			// Implode de la direccion de la imagen actualizada
			$new_dir = implode('/',$new_dir);
			// Asignamos la id de la publicacion
			$id_publi = $value['id_publicacion'];
			// Realizamos la query cambiando la nueva direccion en la base de datos
			query("UPDATE `publicaciones` SET `img`='$new_dir' WHERE `id_publicacion` = '$id_publi'",true);
		}
		return true;
	}

	// Funcion para cambiar el nombre del usuario en su avatar en la base de datos
	// $new_nick->Nuevo nombre
	function changeAvatar($new_nick){
		// Buscamos la direccion con el nuevo nombre
		$avatar_dir = query("SELECT `avatar` FROM `usuarios` WHERE `nick` = '$new_nick'",true);
		// Si se encuentra la direccion de la imagen
		if ($avatar_dir != null) {
			// Explode de la direccion de la imagen
			$new_dir = explode('/', $avatar_dir[0]['avatar']);
			// Asignamos el nuevo nombre a la direccion
			$new_dir[2] = $new_nick;
			// Implode de la direccion de la imagen actualizada
			$new_dir = implode('/',$new_dir);
			// Realizamos la query cambiando la nueva direccion en la base de dato
			query("UPDATE `usuarios` SET `avatar`='$new_dir' WHERE `nick` = '$new_nick'",true);
			return true;	
		}
		// Si no se encuentra la direccion de la imagen retorna False
		return false;
	}

	// Funcion para cambiar la direccion del banner en la base de datos
	// $new_nick->Nuevo nombre
	function changeBanner($new_nick){
		// Buscamos la direccion con el nuevo nombre
		$banner_dir = query("SELECT `banner` FROM `usuarios` WHERE `nick` = '$new_nick'",true);
		// Si se encuentra la direccion de la imagen
		if ($banner_dir != null) {
			// Explode de la direccion de la imagen
			$new_dir = explode('/', $banner_dir[0]['banner']);
			// Asignamos el nuevo nombre a la direccion
			$new_dir[2] = $new_nick;
			// Implode de la direccion de la imagen actualizada
			$new_dir = implode('/',$new_dir);
			// Realizamos la query cambiando la nueva direccion en la base de dato
			query("UPDATE `usuarios` SET `banner`='$new_dir' WHERE `nick` = '$new_nick'",true);
			return true;		
		}
		// Si no se encuentra la direccion de la imagen retorna False
		return false;
	}

	// Funcion para cambiar de direccion las imagenes
	function updateImage($user,$name_column,$image){
		// Dividimos el tipo de imagen		
		$image_txt = explode('.',$image['name']);
	
		// Asignamos el nombre a las imagenes
		$image_txt = $name_column.'_'.$user.'.'.$image_txt[1];

		if (move_uploaded_file($image['tmp_name'], 'resources/publis_users/'.$user.'/profile/'.$image_txt)) {
			// Si la imagen se sube correctamente se asigna la nueva direccion
			$dir_image = 'resources/publis_users/'.$user.'/profile/'.$image_txt;
			// Realizamos la query para cambiar la direccion en la base de datos
			query("UPDATE `usuarios` SET `$name_column`='$dir_image' WHERE `nick` = '$user'",true);
			return true;
		}
		return false;
	}
 ?>