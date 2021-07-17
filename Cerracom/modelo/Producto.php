<?php
class Producto {
    public $IdProducto;
    public $NombreProducto;
    public $Descripcion;
    public $Precio;
    public $Stock;
    public $Categoria;
    public $Marca;
    public $Descuento;
    public $Proveedor;
    public $Estado;
    public $Foto;

    function __construct(){}
    
    function __construct1($IdProducto, $NombreProducto, $Descripcion,
                            $Precio, $Stock, $Categoria,
                            $Marca, $Descuento, $Proveedor,
                            $Estado, $Foto)
    {
        $this->IdProducto=$IdProducto;
        $this->NombreProducto=$NombreProducto;
        $this->Descripcion=$Descripcion;
        $this->Precio=$Precio;
        $this->Stock=$Stock;
        $this->Categoria=$Categoria;
        $this->Marca=$Marca;
        $this->Descuento=$Descuento;
        $this->Proveedor=$Proveedor;
        $this->Estado=$Estado;
        $this->Foto=$Foto;

    }

}
?>