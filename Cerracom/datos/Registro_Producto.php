<?php

require_once '../datos/Producto_DAO.php';
require_once '../modelo/Producto.php';

$dao = new Producto_DAO();
$producto = new Producto();

if(isset($_POST["btnProducto"])){
    
    $producto->NombreProducto=$_POST["NombreProducto"];
    $producto->Descripcion=$_POST["Descripcion"];
    $producto->Precio = $_POST["Precio"];
    $producto->Stock = $_POST["Stock"];
    $producto->Categoria = $_POST["Categoria"];
    $producto->Marca=$_POST["Marca"];
    $producto->Descuento=$_POST["Descuento"];
    $producto->Proveedor=$_POST["Proveedor"];
    $producto->Estado=$_POST["Estado"];

    try{
      if(!empty( $_FILES['Foto']) &&  $_FILES['Foto']['size']>0){
       
        $producto->Foto=basename($_FILES['Foto']['name']);
        $dir_subir='files/'. $asesor->Foto;
        $enviar=move_uploaded_file($_FILES['Foto']['tmp_name'],$dir_subir);
        
      
       $dao->agregar($producto);
      }

      var_dump($_POST);
       header("location: ../app/login.php");
     //   require_once 'menu_asesor.php'
    }catch(Exception $e){
        $_SESSION["success"]="registrado";
        
        //var_dump($e);
       header("location: ../app/index.php");
    } 
   

  }  else{
    $_SESSION["error"]=" no registrado";
    }


?>