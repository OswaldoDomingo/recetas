<?php
// controlador_receta
//Errores
$errores = [];
if(isset($_POST['enviar'])){
    //recoger nombre de la receta
    $nombreReceta = eliminaEspacios('nombreReceta');
    //recoge receta
    //Conservo los saltos de línea nl2br
    $descripcion =eliminaEtiquetas('descripcion');
    //recoge estación de receta se comprueba en un array si está la estación
    // $estacion = $_POST['estacion'];
    $estacion = estacion('estacion');
    //El archivo de imagen, solo recojo el nombre de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = $imagen['name'];

    echo "<br>Nombre de la receta: " . $nombreReceta . "<br>\n";
    echo "Estación del año que se hace esta receta: " .$estacion . "<br>\n";
    echo "Ingredientes y cómo se elabora:<br> " . $descripcion . "<br>\n";
    echo "Nombre del fichero de la imagen: " . $nombreImagen . "<br>\n";
    echo "Imagen: <br><img src= 'imagenes/" . $nombreImagen . "' <br>\n";
}

//Eliminar etiquetas de el textarea
function eliminaEtiquetas($texto){
    global $errores;
    if(isset($_REQUEST[$texto])){
        $resultado = nl2br(strip_tags($_REQUEST[$texto]));
    } else{
        $errores['nombreReceta'] = "Error en el nombre de la receta";
        $resultado = "";
    }
    return $resultado;
}
//Elimina espacios delante y final del texto
function eliminaEspacios($variable){
    global $errores;
    if(isset($_REQUEST[$variable])){
        $resultado = trim($_REQUEST[$variable]);
    } else{
        $errores[] = "Error en el nombre";
        $resultado = "";
    }
    return $resultado;
}

//Saber si se encuentra en el array la estación del año
function estacion($variableEstacion){
    global $errores;
    $listaEstaciones = ['primavera', 'verano', 'otonyo', 'invierno', 'atemporal'];
    $resultado ="";
    if(isset($_REQUEST[$variableEstacion])){
        $valorEstacion = $_REQUEST[$variableEstacion];
        if(in_array($valorEstacion, $listaEstaciones)){
            $resultado = $_REQUEST[$variableEstacion];
        } else {
            $errores['estacion'] = "Error en las estaciones";
            $resultado = " ";
        }
    }
    return $resultado;
}


?>