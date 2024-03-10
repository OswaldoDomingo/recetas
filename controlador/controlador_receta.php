<?php
// controlador_receta
if(isset($_POST['enviar'])){
    //recoger nombre de la receta
    $nombreReceta = $_POST['nombreReceta'];
    //recoge receta
    //Conservo los saltos de línea nl2br
    $descripcion = nl2br($_POST['descripcion']);
    //recoge estación de receta
    $estacion = $_POST['estacion'];
    //El archivo de imagen, solo recojo el nombre de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = $imagen['name'];

    echo "Nombre de la receta: " . $nombreReceta . "<br>\n";
    echo "Estación del año que se hace esta receta: " .$estacion . "<br>\n";
    echo "Ingredientes y cómo se elabora:<br> " . $descripcion . "<br>\n";
    echo "Nombre del fichero de la imagen: " . $nombreImagen . "<br>\n";
    echo "Imagen: <br><img = src= 'imagenes/" . $nombreImagen . "' <br>\n";
}


?>