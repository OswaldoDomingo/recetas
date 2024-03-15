<?php
require_once 'bGeneral.php';
// controlador_receta
//Errores
$errores = [];
if (isset($_POST['enviar'])) {
    //recoge nombre de usuario
    $usuario = eliminaEspacios('usuario');
    //recoge número de teléfono
    $telefono = eliminaEspacios('telefono');
    //recoger nombre de la receta
    $nombreReceta = eliminaEspacios('nombreReceta');
    //recoge receta
    //Conservo los saltos de línea nl2br
    $descripcion = eliminaEtiquetas('descripcion');
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
    echo "Estación del año que se hace esta receta: " . $estacion . "<br>\n";
    echo "Ingredientes y cómo se elabora:<br> " . $descripcion . "<br>\n";
    echo "Nombre del fichero de la imagen: " . $nombreImagen . "<br>\n";
    echo "Imagen: <br><img src= 'imagenes/" . $nombreImagen . "' <br>\n";
    // Llamar a la función para subir la imagen
    if (subirImagen('imagen')) {
        echo "Imagen subida correctamente.";
        // Aquí puedes guardar $rutaArchivo en tu base de datos si es necesario
    } else {
        echo "Hubo un error al subir la imagen.";
    }
} else {
    echo "No me lo has enviado desde el formulario";
}

//Eliminar etiquetas de el textarea
function eliminaEtiquetas($texto)
{
    global $errores;
    if (isset($_REQUEST[$texto])) {
        $resultado = nl2br(strip_tags($_REQUEST[$texto]));
    } else {
        $errores['nombreReceta'] = "Error en el nombre de la receta";
        $resultado = "";
    }
    return $resultado;
}
//Elimina espacios delante y final del texto
function eliminaEspacios($variable)
{
    global $errores;
    if (isset($_REQUEST[$variable])) {
        $resultado = trim($_REQUEST[$variable]);
    } else {
        $errores[] = "Error en el nombre";
        $resultado = "";
    }
    return $resultado;
}

//Saber si se encuentra en el array la estación del año
function estacion($variableEstacion)
{
    global $errores;
    $listaEstaciones = ['primavera', 'verano', 'otonyo', 'invierno', 'atemporal'];
    $resultado = "";
    if (isset($_REQUEST[$variableEstacion])) {
        $valorEstacion = $_REQUEST[$variableEstacion];
        if (in_array($valorEstacion, $listaEstaciones)) {
            $resultado = $_REQUEST[$variableEstacion];
        } else {
            $errores['estacion'] = "Error en las estaciones";
            $resultado = " ";
        }
    }
    return $resultado;
}

//Función para subir imágenes
function subirImagen($inputNombre)
{
    //Verificar si se ha subido el archivo
    if (empty($_FILES[$inputNombre]['name'])) {
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
    if (in_array($extension, $extensionesPermitidas) && $tamanoImagen <= $tamanoMaximo) {
        //Intentar subir el fichero
        if (move_uploaded_file($tempImagen, $rutaArchivo)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
//funcion para que
function crearVariable($str)
{
    // Reemplazar espacios y caracteres especiales por guiones bajos
    $str = preg_replace('/[^a-zA-Z0-9]/', '_', $str);
    // Paso 2: Convertir a minúsculas
    $str = strtolower($str);
    // Crear la variable con el nombre resultante
    return ${$str};
}

//Vamos a guardar la información en un fichero llamado recetas.txt
//Se guardará un array con el nombre del plato $arrozAlHorno{
/** 
 * "nombreReceta"=>$nombreReceta ,
 * "usuario=>$usuario,
 * "telefono"=>$telefono,
 * "descripcion => "$descripcion,
 * "estacion =>  $estacion,
 * "imagen" => $nombreImagen
 */

function addReceta($nombreReceta, $usuario, $telefono, $descripcion, $estacion, $imagen, &$errores)
//function addReceta()
{
    $recetario = fopen('C:\\servidor\\apache24\\htdocs\\recetas\\recetario\\recetas.txt', 'a+');
    $volumen = filesize('C:\\servidor\\apache24\\htdocs\\recetas\\recetario\\recetas.txt'); //tamaño del archivo
    // $variableNombreReceta =""; //Nombre que se va a usar para nombrar la variable
    if ($recetario == false) {
        echo "Error al abrir el fichero";
    } else {
        //$contenido = fread($recetario, $volumen); //Leer el contenido del fichero, hay que ver el vídeo de lectura de fichero
        //echo $contenido;//Mostrar contenido
        //Escribir lo que necesitemos en el fichero en forma de array para guardar las recetas
        //Recoger los datos, antes se ha de coger el nombre de la receta y dejarla sin espacios
        //pasar el nombre a minúsculas

        //se comprueba que la variable $nombreReceta tenga un nombre, si no se pone el valor "vacio"
        if (!$nombreReceta) {
            $nombreReceta = "vacio";
        } else {
            //Se elimina los espacios en blando delante y detrás y se eliminan espacios sobrantes dentro de el nombre, luego se pasa a minúsculas
            $variableNombreReceta = strtolower(preg_replace('/\s+/', '_', trim($nombreReceta)));
        }
        //Guardado de recetas en una sola línea para poder recuperar cada receta
        $descripcion = strip_tags($descripcion); //Elimina los caracteres html
        //Reemplazar los saltos de línea retornos y espacios en un espacio
        $descripcion = str_replace(["\n",  "\r", "  "], " ", $descripcion);
        //Escribir el array en una sola línea
        //$informacionReceta = "$$variableNombreReceta = [\"receta\" => \"$nombreReceta\",\"nombre\" => \"$usuario\", \"telefono\" => \"$telefono\", \"descripcion\" => //\"$descripcion\", \"estacion\" => \"$estacion\", \"imagen\" => \"$imagen\"]" . PHP_EOL;
        //Si $nombreReceta el valor es vacio, no escribe  el array ya que no tendríamos nombre de valiable del array
        // Crear el array asociativo para la receta
        $receta = [
            "receta" => $nombreReceta,
            "nombre" => $usuario,
            "telefono" => $telefono,
            "descripcion" => $descripcion,
            "estacion" => $estacion,
            "imagen" => $imagen
        ];
        // Convertir el array a formato JSON conservando caracteres como ñ y acentos
        $jsonReceta = json_encode($receta, JSON_UNESCAPED_UNICODE);
        
        if ($nombreReceta != "vacio") {
            //Se escribe la línea en el archivo
            fwrite($recetario, $jsonReceta);
            //si ha quedadoi algo en el buffer se escribe en la línea
            fflush($recetario);
        } else {
            $errores['nombreReceta'] = "No se puso el nombre al campo";
        }
    }
    fclose($recetario);
}

function leerRecetario()
{
    $rutaArchivo = 'C:\\servidor\\apache24\\htdocs\\recetas\\recetario\\recetas.txt';
    $recetario = fopen($rutaArchivo, 'r');
    $receta = "";

    if ($recetario === false) {
        echo "Error al abrir el fichero";
    } else {
        while (!feof($recetario)) {
            // Leer una línea del archivo y eliminar espacios en blanco al inicio y al final
            $linea = trim(fgets($recetario));

            // Verificar si la línea no está vacía
            if (!empty($linea)) {
                // Decodificar la línea como JSON en lugar de usar eval()
                $receta = json_decode($linea, true);

                // Verificar si $receta es un array y mostrar sus elementos
                if (is_array($receta)) {
                    foreach ($receta as $clave => $valor) {
                        echo $clave . " es " . $valor . "<br>";
                    }
                    echo "<br>";
                } else {
                    echo "Error al decodificar la línea: No es un array asociativo<br>";
                }
            }
        }
    }
    fclose($recetario);
}
