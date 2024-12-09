<?php
// Llamar al archivo de conexión.
include("conexion.php");

// Verificar si se recibió el parámetro 'id_tarea' y no está vacío
if (isset($_REQUEST['id_tarea']) && !empty($_REQUEST['id_tarea'])) {
    // Convertir 'id_tarea' en un número entero para evitar inyecciones SQL
    $id_tarea = (int)$_REQUEST['id_tarea'];

    // Crear conexión con la base de datos
    $conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

    // Verificar la conexión
    if (!$conexion) {
        die("No se ha podido establecer conexión con el servidor: " . mysqli_connect_error());
    }

    // Consulta para obtener los datos de la tarea
    $consulta = "SELECT * FROM tareas WHERE id_tarea = ?";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_tarea);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Verificar si se encontró la tarea
        if ($columna = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            // Mostrar el formulario con los datos existentes
            ?>
            <html>
            <body>
            <form action="datos_actualizados.php" method="POST">
                <fieldset>
                    <legend class="datos">EDITAR DATOS DE LA TAREA</legend>
                    <input type="hidden" name="id_tarea" value="<?php echo htmlspecialchars($columna['id_tarea']); ?>"/>
                    
                    <label>TÍTULO DE LA TAREA</label>
                    <input type="text" name="titulo" value="<?php echo htmlspecialchars($columna['titulo']); ?>" required/><br>
                    
                    <label>TIPO</label>
                    <select name="tipo" required>
                        <option value="PROYECTO" <?php echo ($columna['tipo'] == "PROYECTO" ? "selected" : ""); ?>>PROYECTO</option>
                        <option value="PRESENTACION" <?php echo ($columna['tipo'] == "PRESENTACION" ? "selected" : ""); ?>>PRESENTACIÓN</option>
                        <option value="PRACTICA" <?php echo ($columna['tipo'] == "PRACTICA" ? "selected" : ""); ?>>PRÁCTICA</option>
                        <option value="INVESTIGACION" <?php echo ($columna['tipo'] == "INVESTIGACION" ? "selected" : ""); ?>>INVESTIGACIÓN</option>
                        <option value="ENSAYO" <?php echo ($columna['tipo'] == "ENSAYO" ? "selected" : ""); ?>>ENSAYO</option>
                        <option value="EXAMEN" <?php echo ($columna['tipo'] == "EXAMEN" ? "selected" : ""); ?>>EXAMEN</option>
                        <option value="OTROS" <?php echo ($columna['tipo'] == "OTROS" ? "selected" : ""); ?>>OTROS</option>
                    </select><br>
                    
                    <label>MATERIA</label>
                    <input type="text" name="materia" value="<?php echo htmlspecialchars($columna['materia']); ?>" required/><br>
                    
                    <label>DESCRIPCIÓN</label>
                    <textarea name="descripcion" required><?php echo htmlspecialchars($columna['descripcion']); ?></textarea><br>
                    
                    <label>FECHA DE ENTREGA</label>
                    <input type="date" name="fecha_entrega" value="<?php echo htmlspecialchars($columna['fecha_entrega']); ?>" required/><br>
                    
                    <label>ESTADO</label>
                    <select name="estado" required>
                        <option value="INCOMPLETO" <?php echo ($columna['estado'] == "INCOMPLETO" ? "selected" : ""); ?>>INCOMPLETO</option>
                        <option value="COMPLETO" <?php echo ($columna['estado'] == "COMPLETO" ? "selected" : ""); ?>>COMPLETO</option>
                    </select><br>
                    
                    <input type="submit" value="MODIFICAR">
                    <input type="reset" value="BORRAR">
                </fieldset>
            </form>
            </body>
            </html>
            <?php
        } else {
            echo "No se encontraron datos para el ID de tarea proporcionado.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "ID de tarea no especificado o vacío.";
}
?>
