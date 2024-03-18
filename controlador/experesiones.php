<?php
require_once 'controlador_receta.php';

//vamos a comprtobar si existen recetas con algún ingrediente en el fichero de texto
//Cargar fichero en modo lectura solo r, recorrerlo línea a línea, y si existe el ingrediente decir que hay con ese ingrediente

$rutaFichero = 'C:\\servidor\\apache24\\htdocs\\recetas\\recetario\\recetas.txt';
$fichero = fopen($rutaFichero, 'r'); //abrir fichero
$tipo = 'cAlDo';
$patron = "/" . $tipo . "/i";
//recorrer línea a línea el archivo de texto
if($fichero != false){
    while(!feof($fichero)){
        $linea = trim(fgets($fichero));
        if(!empty($linea) &&  preg_match($patron, $linea)){
            
            echo "\nSí hay recetas con " . strtolower($tipo) . "\n";
        } else {
            echo "\nNo hay recetas con " . strtolower($tipo) . "\n";
        }
    }
}

