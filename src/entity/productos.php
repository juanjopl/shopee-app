<?php
require_once(__DIR__ . 'src/../p2/p2_lib.php');
    class Producto {
        public $idProducto;
        public $titulo;
        public $descripcion;
        public $estado;
        public $precio;
        public $fechaCreacion;
        public $idVendedor;
        public $idComprador;
        public $idCategoria;
        public $idSubcategoria;
        public $imagenes;
        public $estadoProducto;
        public $oferta;

        public static function parse ($datos) {
            $obj = new Producto();
            $obj->idProducto = $datos['idProducto'];
            $obj->titulo = $datos['titulo'];
            $obj->descripcion = $datos['descripcion'];
            $obj->estado = $datos['estado'];
            $obj->precio = $datos['precio'];
            $obj->fechaCreacion = $datos['fechaCreacion'];
            $obj->idVendedor = $datos['idVendedor'];
            $obj->idComprador = $datos['idComprador'];
            $obj->idCategoria = $datos['idCategoria'];
            $obj->idSubcategoria = $datos['idSubcategoria'];
            $obj->estadoProducto = $datos['estadoProducto'];
            $obj->oferta = $datos['oferta'];

            $con = get_connection();
            $sql = "SELECT imagen FROM fotosproductos WHERE idProducto=:idProducto;";
            $statement = $con->prepare($sql);
            $statement->bindParam(':idProducto',$obj->idProducto);
            $statement->execute();
            
            $obj->imagenes = $statement->fetchAll(PDO::FETCH_COLUMN);

            return $obj;
        }
        //FUNCION PARA GENERAR LA PAGINACION EN EL INDEX
        public static function getPaginacion ($pagina,$registros, $idVendedor=null) {
            $productos = [];
            $con = get_connection();
            try {
                $offset = ($pagina - 1) * $registros;
                if ($idVendedor == null) {
                $sql = "SELECT * FROM productos WHERE estadoProducto = 'activo' OR estadoProducto = 'reservado' LIMIT :offset, :registros";
                }else {
                $sql = "SELECT * FROM productos WHERE idVendedor != :idVendedor AND (estadoProducto = 'activo' OR estadoProducto = 'reservado') LIMIT :offset, :registros";
                }
                $statement = $con->prepare($sql);
                if($idVendedor !== null) {
                    $statement->bindParam(':idVendedor', $idVendedor, PDO::PARAM_INT);
                }
                $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
                $statement->bindParam(':registros', $registros, PDO::PARAM_INT);
                $statement->execute();
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $productos[] = Producto::parse ($row);
                }
                return $productos;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                cerrarConexion($con);
            }
        }
        //FUNCION PARA CONTAR LOS PRODUCTOS
        public static function contarProductos ($idVendedor=null) {
            $con = get_connection();
            if($idVendedor !== null) {
                $sql = "SELECT COUNT(`idProducto`) AS total FROM productos WHERE idVendedor != :idVendedor AND (estadoProducto = 'activo' OR estadoProducto = 'reservado');";
                $statement = $con->prepare($sql);
                $statement->bindParam(':idVendedor',$idVendedor,PDO::PARAM_INT); 
            }else {
                $sql = "SELECT COUNT(`idProducto`) AS total FROM productos WHERE estadoProducto = 'activo' OR estadoProducto = 'reservado';";
                $statement = $con->prepare($sql);
            }
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            if($resultado) {
                return $resultado['total'];
            }
        }
        //FUNCION PARA RECOGER PRODUCTOS Y MOSTRARLOS EN LA TABLA DEL ADMIN
        public static function recogerProductos($categoria = null, $subcategoria = null,$estadoProducto = null) {
            $con = get_connection();
            $sql = "SELECT * FROM productos WHERE 1";
            if ($categoria !== null) {
                $sql .= " AND idCategoria = :categoria";
            }
            if ($subcategoria !== null) {
                $sql .= " AND idSubcategoria = :subcategoria";
            }
            if ($estadoProducto !== null) {
                $sql .= " AND estadoProducto = :estadoProducto";
            }
            $statement = $con->prepare($sql);
            if ($categoria !== null) {
                $statement->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            }
            if ($subcategoria !== null) {
                $statement->bindParam(':subcategoria', $subcategoria, PDO::PARAM_INT);
            }
            if ($estadoProducto !== null) {
                $statement->bindParam(':estadoProducto', $estadoProducto, PDO::PARAM_STR);
            }
            $statement->execute();
            $productos = [];
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = Producto::parse($row);
            }
            if (empty($productos)) {
                return null;
            } else {
                return $productos;
            }
        }
        //FUNCION PARA RECOGER LOS PRODUCTOS SEGUN LOS FILTROS QUE SE PONGAN
        public static function productosFiltrados($categoria, $subcategoria, $idVendedor) {
            $productos = [];
            $con = get_connection();
            $sql = "SELECT * FROM productos WHERE (estadoProducto = 'activo' OR estadoProducto = 'reservado')";
            if ($categoria !== null) {
                $sql .= " AND idCategoria = :categoria";
            }
            if ($subcategoria !== null) {
                $sql .= " AND idSubcategoria = :subcategoria";
            }
            if ($idVendedor !== null) {
                $sql .= " AND idVendedor != :idVendedor";
            }
            $statement = $con->prepare($sql);
            if ($categoria !== null) {
                $statement->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            }
            if ($subcategoria !== null) {
                $statement->bindParam(':subcategoria', $subcategoria, PDO::PARAM_INT);
            }
            if ($idVendedor !== null) {
                $statement->bindParam(':idVendedor', $idVendedor, PDO::PARAM_INT);
            }
            $statement->execute();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = Producto::parse($row);
            }
            if (empty($productos)) {
                return null;
            } else {
                return $productos;
            }
        }
    }
?>