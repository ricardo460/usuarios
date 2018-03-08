<?php
// incluye la clase Db
require_once('bd.php');

	class CrudUsuario{
		// constructor de la clase
		public function __construct(){}

		// método para insertar, recibe como parámetro un objeto de tipo libro
		public function insertar($usuario){
			$db=Db::conectar();
			$insert=$db->prepare('INSERT INTO usuario values(NULL,:nombre,:apellido,:fechaNacimiento,:edad,:cedula,:correo)');
			$insert->bindValue('nombre',$usuario->getNombre());
			$insert->bindValue('apellido',$usuario->getApellido());
			$insert->bindValue('fechaNacimiento',$usuario->getFechaNacimiento());
			$insert->bindValue('edad',$usuario->getEdad());
			$insert->bindValue('cedula',$usuario->getCedula());
			$insert->bindValue('correo',$usuario->getCorreo());
			$insert->execute();

		}

		// método para mostrar todos los libros
		public function mostrar(){
			$db=Db::conectar();
			$listaUsuarios=[];
			$select=$db->query('SELECT * FROM usuario');

			foreach($select->fetchAll() as $usuario){
				$myUsuario= new Usuario();
				$myUsuario->setId($usuario['id']);
				$myUsuario->setNombre($usuario['nombre']);
				$myUsuario->setApellido($usuario['apellido']);
				$myUsuario->setFechaNacimiento($usuario['fechaNacimiento']);
				$myUsuario->setEdad($usuario['edad']);
				$myUsuario->setCedula($usuario['cedula']);
				$myUsuario->setCorreo($usuario['correo']);
				$listaUsuarios[]=$myUsuario;
			}
			return $listaUsuarios;
		}

		// método para eliminar un libro, recibe como parámetro el id del libro
		public function eliminar($id){
			$db=Db::conectar();
			$eliminar=$db->prepare('DELETE FROM usuario WHERE ID=:id');
			$eliminar->bindValue('id',$id);
			$eliminar->execute();
		}

		// método para buscar un libro, recibe como parámetro el id del libro
		public function obtenerUsuario($id){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM usuario WHERE ID=:id');
			$select->bindValue('id',$id);
			$select->execute();
			$usuario=$select->fetch();
			$myUsuario= new Libro();
			$myUsuario->setId($usuario['id']);
			$myUsuario->setNombre($usuario['nombre']);
			$myUsuario->setApellido($usuario['apellido']);
			$myUsuario->setFechaNacimiento($usuario['fechaNacimiento']);
			$myUsuario->setEdad($usuario['edad']);
			$myUsuario->setCedula($usuario['cedula']);
			$myUsuario->setCorreo($usuario['correo']);
			return $myUsuario;
		}

		// método para actualizar un Usuario, recibe como parámetro el Usuario
		public function actualizar($usuario){
			$db=Db::conectar();
			$actualizar=$db->prepare('UPDATE usuario SET nombre=:nombre, apellido=:apellido, fechaNacimiento=:fechaNacimiento, edad=:edad, cedula=:cedula, correo=:correo  WHERE ID=:id');
			$actualizar->bindValue('id',$usuario->getId());
			$actualizar->bindValue('nombre',$usuario->getNombre());
			$actualizar->bindValue('apellido',$usuario->getApellido());
			$actualizar->bindValue('fechaNacimiento',$usuario->getFechaNacimiento());
			$actualizar->bindValue('edad',$usuario->getEdad());
			$actualizar->bindValue('cedula',$usuario->getCedula());
			$actualizar->bindValue('correo',$usuario->getCorreo());
			$actualizar->execute();
		}
	}
?>