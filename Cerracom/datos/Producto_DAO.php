<?php
require_once 'Conexion.php'; /*importa Conexion.php*/
require_once '../modelo/Producto.php'; /*importa el modelo */

class Producto_DAO
{
    
	private $conexion; /*Crea una variable conexion*/
        
    private function conectar(){
        try{
			$this->conexion = Conexion::abrirConexion(); /*inicializa la variable conexion, llamando el metodo abrirConexion(); de la clase Conexion por medio de una instancia*/
		}
		catch(Exception $e)
		{
			die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
		}
    }
    
    
   /*Metodo que obtiene todos los alumnos de la base de datos, retorna una lista de objetos */
	public function obtenerTodos()
	{
		try
		{
            $this->conectar();
            
			$lista = array(); /*Se declara una variable de tipo  arreglo que almacenará los registros obtenidos de la BD*/

			$sentenciaSQL = $this->conexion->prepare("SELECT IdProducto, NombreProducto, Descripcion, Precio, Stock, Categoria,Marca, Descuento,Proveedor, Estado,Foto
			FROM producto"); /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
			
			$sentenciaSQL->execute();/*Se ejecuta la sentencia sql, retorna un cursor con todos los elementos*/
            
            /*Se recorre el cursor para obtener los datos*/
			foreach($sentenciaSQL->fetchAll(PDO::FETCH_OBJ) as $fila)
			{
				$obj = new Producto();

        $obj->IdProducto=$fila->IdProducto;
        $obj->NombreProducto=$fila->NombreProducto;
        $obj->Descripcion=$fila->Descripcion;
        $obj->Precio=$fila->Precio;
        $obj->Stock=$fila->Stock;
        $obj->Categoria=$fila->Categoria;
        $obj->Marca=$fila->Marca;
        $obj->Descuento=$fila->Descuento;
        $obj->Proveedor=$fila->Proveedor;
        $obj->Estado=$fila->Estado;
        $obj->Foto=$fila->Foto;

			$lista[] = $obj;
			
			}
            
			return $lista;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return null;
		}
		finally
		{
            Conexion::cerrarConexion();
        }
	}
    
    /*Metodo que obtiene un registro de la base de datos, retorna un objeto */
	public function obtenerUno($IdProducto)
	{
		try
		{ 
            $this->conectar();
            
			$registro = null; /*Se declara una variable  que almacenará el registro obtenido de la BD*/
            
			$sentenciaSQL = $this->conexion->prepare("SELECT IdProducto, NombreProducto, Descripcion, Precio, Stock, Categoria,Marca, Descuento,Proveedor, Estado,Foto
			FROM producto WHERE IdProducto=?"); /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
			$sentenciaSQL->execute([$IdProducto]);/*Se ejecuta la sentencia sql, retorna un cursor con todos los elementos*/
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
			
            $registro = new Producto;
            $registro->IdProducto=$fila->IdProducto;
            $registro->NombreProducto=$fila->NombreProducto;
            $registro->Descripcion=$fila->Descripcion;
            $registro->Precio=$fila->Precio;
            $registro->Stock=$fila->Stock;
            $registro->Categoria=$fila->Categoria;
            $registro->Marca=$fila->Marca;
            $registro->Descuento=$fila->Descuento;
            $registro->Proveedor=$fila->Proveedor;
            $registro->Estado=$fila->Estado;
            $registro->Foto=$fila->Foto;
			
			return $registro; //Registro es un Empleado (objeto Empleado)
		}
		catch(Exception $e)
		{
            echo $e->getMessage();
            return null;
		}
		finally
		{
            Conexion::cerrarConexion();
        }
	}
    
    //Elimina el alumno con el id indicado como parámetro
	public function eliminar($IdProducto)
	{
		try 
		{
			$this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM producto WHERE IdProducto = ?");			          
            
			$sentenciaSQL->execute(array($IdProducto));
            return true;
		}
		catch (Exception $e) 
		{
            return false;
		}
		finally
		{
            Conexion::cerrarConexion();
        }
        
	}

	public function agregar(Producto $obj)
	{
        $IdProducto=0;
		try 
		{
            $sql = "INSERT INTO producto (IdProducto, NombreProducto, Descripcion, Precio, Stock, Categoria,Marca, Descuento,Proveedor, Estado,Foto)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			
			//var_dump($sql);
			$this->conectar();
			
            $this->conexion->prepare($sql)
                 ->execute(
                array(
                    $obj->IdProducto,
                    $obj->NombreProducto,
                    $obj->Descripcion,
                    $obj->Precio,
                    $obj->Stock,
                    $obj->Categoria,
                    $obj->Marca,
                    $obj->Descuento,
                    $obj->Proveedor,
                    $obj->Estado,
                    $obj->Foto
				));

            $IdProducto=$this->conexion->lastInsertId();
			//var_dump($IdProducto);
			
			return $IdProducto;
			
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
			return $IdProducto;
		}
		finally
		{
            /*
            En caso de que se necesite manejar transacciones, no deberá desconectarse mientras la transacción deba persistir
            */
            Conexion::cerrarConexion();
        }
	}

	public function editar($IdProducto)
	{
		try 
		{
			$sql = "UPDATE producto SET NombreProducto  = ?, Descripcion = ?, Precio = ?, 
            Stock = ?, Categoria = ?,Marca = ?, Descuento = ?,Proveedor = ?, Estado = ?,Foto = ?
			WHERE IdProducto = ?";

            $this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare($sql);			          
			$sentenciaSQL->execute(
				array(
                    $obj->NombreProducto,
                    $obj->Descripcion,
                    $obj->Precio,
                    $obj->Stock,
                    $obj->Categoria,
                    $obj->Marca,
                    $obj->Descuento,
                    $obj->Proveedor,
                    $obj->Estado,
                    $obj->Foto
				));

			return true;
			
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
			return false;
		}
		finally
		{
            Conexion::cerrarConexion();
        }
	}
}