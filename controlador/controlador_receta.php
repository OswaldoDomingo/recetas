<?php
require_once 'bGeneral.php';
// controlador_receta
//Errores
$errores = [];
if(isset($_POST['enviar'])){
    //recoge nombre de usuario
    $usuario = eliminaEspacios('usuario');
    //recoge número de teléfono
    $telefono = eliminaEspacios('telefono');
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
    echo "<br>";
    echo "Nombre usuario: " . $usuario . "<br>\n";
    echo "Teléfono de contacto: " . $telefono  . "<br>\n";
    echo "<br>Nombre de la receta: " . $nombreReceta . "<br>\n";
    echo "Estación del año que se hace esta receta: " .$estacion . "<br>\n";
    echo "Ingredientes y cómo se elabora:<br> " . $descripcion . "<br>\n";
    echo "Nombre del fichero de la imagen: " . $nombreImagen . "<br>\n";
    echo "Imagen: <br><img src= 'imagenes/" . $nombreImagen . "' <br>\n";
    // Llamar a la función para subir la imagen
    if(subirImagen('imagen')){
        echo "Imagen subida correctamente.";
        // Aquí puedes guardar $rutaArchivo en tu base de datos si es necesario
    } else {
        echo "Hubo un error al subir la imagen.";
    }
} else {
    echo "No me lo has enviado desde el formulario";
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

//Función para subir imágenes
function subirImagen($inputNombre){
    //Verificar si se ha subido el archivo
    if(empty($_FILES[$inputNombre]['name'])){
        echo "No se ha seleccionado ningún archivo";
        return false;
    }

    //Directorio donde se van a guardar las imágenes
    // $directorio = "imagenes/"; 
    //Esta forma de arriba también sirve
    //Hay que poner al final la / ó \\ para que se sepa que es un directorio
    $directorio = "C:\\servidor\\apache24\\htdocs\\recetas\\imagenes\\";
    //extensiones permitidas
    $extensionesPermitidas = array('jpg', 'png');
    //Tamaño máximo 25KB
    $tamanoMaximo = 25000;

    //Recoger el FILE del input
    $imagen = $_FILES[$inputNombre];
    $nombreImagen = $imagen['name'];
    $tamanoImagen = $imagen['size'];
    $tempImagen = $imagen['tmp_name'];

    //Obtener la extensión del archivo
    $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);

    //Generar un nombre único al rchivo
    $nombreArchivo = uniqid() . '.' . $extension;

    //Ruta completa para subir el archivo
    $rutaArchivo = $directorio . $nombreArchivo;

    //Verificar si el archivo es una imagen con las extensiones que queremos
    // y si el tamaño es válido
    if(in_array($extension, $extensionesPermitidas) && $tamanoImagen <= $tamanoMaximo){
        //Intentar subir el fichero
        if(move_uploaded_file($tempImagen, $rutaArchivo)){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}   

?>