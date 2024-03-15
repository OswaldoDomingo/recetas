<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario</title>
    <link rel="shortcut icon" href="imagenes/recetas2.png" type="image/x-icon">
    <link rel="stylesheet" href="vista/estilo.css">
</head>
<body>
    <h1>RECETARIO</h1>
    <img class="logo" src="imagenes/recetas2.png" alt="">
    <?php
        require_once 'controlador/controlador_receta.php';
        require_once 'vista/formulario_receta.php';
        addReceta($nombreReceta, $usuario, $telefono, $descripcion, $estacion, $nombreImagen, $errores[]);
        leerRecetario();
    ?>
</body>
</html>