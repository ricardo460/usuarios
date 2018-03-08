<?php
//incluye la clase Libro y CrudLibro
	require_once('../model/CrudUsuario.php');
	require_once('usuario.php');

	$crud= new CrudUsuario();
	$usuario= new Usuario();

	if(isset($_POST['action']) && !empty($_POST['action'])){ 

		switch ($_POST['action']) {
			case 'insertar':

				$usuario->setNombre($_POST['nombre']);
				$usuario->setApellido($_POST['apellido']);
				$usuario->setFechaNacimiento($_POST['fechaNacimiento']);
				$usuario->setEdad($_POST['edad']);
				$usuario->setCedula($_POST['cedula']);
				$usuario->setCorreo($_POST['correo']);
				$crud->insertar($usuario);
				echo 'ok';
			break;
			case 'actualizar':

				$usuario->setId($_POST['id']);
				$usuario->setNombre($_POST['nombre']);
				$usuario->setApellido($_POST['apellido']);
				$usuario->setFechaNacimiento($_POST['fechaNacimiento']);
				$usuario->setEdad($_POST['edad']);
				$usuario->setCedula($_POST['cedula']);
				$usuario->setCorreo($_POST['correo']);
				$crud->actualizar($usuario);
				echo 'ok';
			break;
			case 'eliminar':

				$crud->eliminar($_POST['id']);
				echo 'ok';
			break;
			case 'mostrar':

				$listaUsuarios=$crud->mostrar();
				$array = formatearUsuarios($listaUsuarios);
				echo json_encode($array);	

			break;
		}
	}

	function formatearUsuarios($e){
		$array = [];
		foreach ($e as $usuario){
			$i = [
				"id"=>$usuario->getId(),
				"nombre"=>$usuario->getNombre(),
				"apellido"=>$usuario->getApellido(),
				"fechaNacimiento"=>$usuario->getFechaNacimiento(),
				"edad"=>$usuario->getEdad(),
				"cedula"=>$usuario->getCedula(),
				"correo"=>$usuario->getCorreo()
			];
			array_push($array , $i);
		}

		return $array;
	}
?>