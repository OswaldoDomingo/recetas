<?php
// controlador_receta
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

    echo "Nombre de la receta: " . $nombreReceta . "<br>\n";
    echo "Estación del año que se hace esta receta: " .$estacion . "<br>\n";
    echo "Ingredientes y cómo se elabora:<br> " . $descripcion . "<br>\n";
    echo "Nombre del fichero de la imagen: " . $nombreImagen . "<br>\n";
    echo "Imagen: <br><img = src= 'imagenes/" . $nombreImagen . "' <br>\n";
}

//Eliminar etiquetas de el textarea
function eliminaEtiquetas($texto){
    if(isset($_REQUEST[$texto])){
        $resultado = nl2br(strip_tags($_REQUEST[$texto]));
    } else{
        $resultado = "";
    }
    return $resultado;
}
//Elimina espacios delante y final del texto
function eliminaEspacios($variable){
    if(isset($_REQUEST[$variable])){
        $resultado = trim($_REQUEST[$variable]);
    } else{
        $resultado = "";
    }
    return $resultado;
}

//Saber si se encuentra en el array la estación del año
function estacion($variableEstacion){
    $listaEstaciones = ['primavera', 'verano', 'otonyo', 'invierno', 'atemporal'];
    $resultado ="";
    if(isset($_REQUEST[$variableEstacion])){
        $valorEstacion = $_REQUEST[$variableEstacion];
        if(in_array($valorEstacion, $listaEstaciones)){
            $resultado = $_REQUEST[$variableEstacion];
        } else {
            $resultado = "No pasó la prueba ->" . $variableEstacion;
        }
    }
    return $resultado;
}


?>