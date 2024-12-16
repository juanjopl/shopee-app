<?php
require_once(__DIR__ . 'src/../p2/p2_lib.php');
class Usuario {
    public $idUsuario;
    public $username;
    public $email;
    public $pass;
	public $nombre;
	public $apellido1;
	public $apellido2;
	public $direccion;
	public $fechaNac;
	public $fechaCreacion;
	public $fechaModificacion;
	public $estado;
	public $perfil;
	public $avatar;
	
	public static function parse ($datos) {
		$obj = new Usuario();
		$obj->idUsuario= $datos['idUsuario'];
        $obj->username = $datos['username'];
        $obj->email = $datos['email'];
		$obj->pass = $datos['pass'];
		$obj->nombre = $datos['nombre'];
		$obj->apellido1 = $datos['apellido1'];
		$obj->apellido2 = $datos['apellido2'];
		$obj->direccion = $datos['direccion'];
		$obj->fechaNac = $datos['fechaNac'];
		$obj->fechaCreacion = $datos['fechaCreacion'];
		$obj->fechaModificacion = $datos['fechaModificacion'];
		$obj->estado = $datos['estado'];
		$obj->perfil = $datos['perfil'];
        $obj->avatar = $datos['avatar'];
		return $obj;
	}
	//FUNCION PARA REGISTRAR A UN USUARIO
	public function addUser() {
		if(validacionesRegistro($this->nombre,$this->username,$this->pass,$this->email,$this->fechaNac,$this->direccion)) {
        //hashear contraseña
        $passEncriptada=password_hash($this->pass, PASSWORD_DEFAULT);
        $this->pass=$passEncriptada;
		//crear usuario
		$conexion = get_connection();
        $sql = "INSERT INTO usuarios (username, email, pass, nombre, apellido1, apellido2, direccion, fechaNac, fechaCreacion, fechaModificacion, estado, perfil) 
                VALUES (:username, :email, :pass, :nombre, :apellido1, :apellido2, :direccion, :fechaNac, :fechaCreacion, :fechaModificacion, :estado, :perfil)";

		// Prepara la consulta
        $consulta = $conexion->prepare($sql);

		$consulta->bindParam(':username', $this->username);
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':pass', $passEncriptada);
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':apellido1', $this->apellido1);
        $consulta->bindParam(':apellido2', $this->apellido2);
        $consulta->bindParam(':direccion', $this->direccion);
        $consulta->bindParam(':fechaNac', $this->fechaNac);
        $consulta->bindParam(':fechaCreacion', $this->fechaCreacion);
        $consulta->bindParam(':fechaModificacion', $this->fechaModificacion);
        $consulta->bindParam(':estado', $this->estado);
        $consulta->bindParam(':perfil', $this->perfil);

        $resultado = $consulta->execute();
        if ($resultado) {
            $this->idUsuario = recogerIdUsuario($this->username);
            cerrarConexion($conexion);
            return true;
        } else {
            cerrarConexion($conexion);
            return false;
        }
	    }
    }
    //FUNCION PARA MODIFICAR USUARIO
    public function modUser($datos, $id) {
        if(validacionesModificar($datos['nombre'],$datos['username'],$datos['pass'],$datos['email'],$datos['direccion'],$this->username,$this->email)) {
    
        if ($datos['pass']!="") {
            $passEncriptada = password_hash($datos['pass'], PASSWORD_DEFAULT);
            $datos['pass'] = $passEncriptada;
        }else {
            $datos['pass'] = $this->pass;
        }

        $con = get_connection();
        $sql = "UPDATE usuarios SET username = :username, email = :email, pass = :pass, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, direccion = :direccion, perfil = :perfil, fechaModificacion = :fechaModificacion WHERE idUsuario = :idUsuario";
        $statement = $con ->prepare($sql);

        $statement->bindParam(':username', $datos['username']);
        $statement->bindParam(':email', $datos['email']);
        $statement->bindParam(':pass', $datos['pass']);
        $statement->bindParam(':nombre', $datos['nombre']);
        $statement->bindParam(':apellido1', $datos['apellido1']);
        $statement->bindParam(':apellido2', $datos['apellido2']);
        $statement->bindParam(':direccion', $datos['direccion']);
        $statement->bindParam(':perfil', $datos['perfil']);
        $statement->bindParam(':fechaModificacion', $datos['fechaModificacion']);
        $statement->bindParam(':idUsuario', $id);

        $result = $statement ->execute();
        if($result) {
            $this->fechaModificacion = date("Y-m-d H:i:s");
            $this->pass = $datos['pass'];
            cerrarConexion($con);
            return true;
        }else {
            cerrarConexion($con);
            return false;
        }
    }
}
    //FUNCION PARA CAMBIAR AVATAR
    public function ponerAvatar($imagen) {
        $con = get_connection();
        $sql = "UPDATE usuarios SET avatar= :imagen WHERE idUsuario= :idUsuario";
        $statement = $con->prepare($sql);
        $statement->bindParam(':idUsuario',$this->idUsuario);
        $statement->bindParam(':imagen',$imagen);
        $resultado = $statement ->execute();
        if($resultado) {
            $this->avatar = $imagen;
        }
    }
    //FUNCION PARA RECOGER LOS USUARIOS Y DESPUES MOSTRARLOS EN LA TABLA DE ADMINISTRADOR
    public static function recogerUsuarios() {
        $con = get_connection();
        $sql = "SELECT * FROM usuarios";
        $statement = $con->prepare($sql);
        $statement->execute();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = Usuario::parse($row);
        }
        if(empty($usuarios)) {
            return null;
        }else {
            return $usuarios;
        }
    }
}
 ?>