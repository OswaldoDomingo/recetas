<!-- formulario_receta -->
<form enctype="multipart/form-data" method="post">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" id="usuario">
    <br>
    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" id="telefono">
    <br>
    <label for="nombreReceta">Nombre de la receta:</label>
    <input type="text" name="nombreReceta" id="nombreReceta">
    <br>
    <label for="descripcion">Descripción</label>
    <br>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
    <br>
    <fieldset>
        <legend>Plato típico de la estación:</legend>
        <br>
        <label for="atemporal">Todo el año</label>
        <input type="radio" name="estacion" value="atemporal" id="atemporal">

        <label for="primavera">Primavera</label>
        <input type="radio" name="estacion" value="primavera" id="primavera">

        <label for="verano">Verano</label>
        <input type="radio" name="estacion" value="verano" id="verano">

        <label for="otonyo">Otoño</label>
        <input type="radio" name="estacion" value="otonyo" id="otonyo">

        <label for="invierno">Invierno</label>
        <input type="radio" name="estacion" value="invierno" id="invierno">
    </fieldset>
    <br>
    <label for="imagen"></label>
    <input type="file" name="imagen" id="imagen">
    <br>
    <input type="submit" value="Enviar" name="enviar">
</form>