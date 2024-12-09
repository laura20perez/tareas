<?php
// Llamar al archivo de conexión.
include("conexion.php");

// Crear la conexión con el servidor
$conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido establecer conexión con el servidor");
// Crear la conexión con la base de datos
$db = mysqli_select_db($conexion, $basedatos) or die("No se ha podido establecer conexión con la base de datos");

// Verificar si se enviaron datos a través del formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['titulo']) && !empty($_POST['titulo']) &&
    isset($_POST['tipo']) && !empty($_POST['tipo']) &&
    isset($_POST['materia']) && !empty($_POST['materia']) &&
    isset($_POST['descripcion']) && !empty($_POST['descripcion']) &&
    isset($_POST['fecha_entrega']) && !empty($_POST['fecha_entrega']) &&
    isset($_POST['estado']) && !empty($_POST['estado'])) {

    // Convertir a mayúsculas
    $titulo = strtoupper(mysqli_real_escape_string($conexion, $_POST['titulo']));
    $tipo = strtoupper(mysqli_real_escape_string($conexion, $_POST['tipo']));
    $materia = strtoupper(mysqli_real_escape_string($conexion, $_POST['materia']));
    $descripcion = strtoupper(mysqli_real_escape_string($conexion, $_POST['descripcion']));
    $fecha_entrega = mysqli_real_escape_string($conexion, $_POST['fecha_entrega']);
    $estado = strtoupper(mysqli_real_escape_string($conexion, $_POST['estado']));

    // Preparar y ejecutar la consulta para insertar el nuevo registro
    $consulta = "INSERT INTO tareas (titulo, tipo, materia, descripcion, fecha_entrega, estado) 
                 VALUES ('$titulo', '$tipo', '$materia', '$descripcion', '$fecha_entrega', '$estado')";

    $resultado = mysqli_query($conexion, $consulta) or die("No se ha podido realizar la consulta: " . mysqli_error($conexion));

    if ($resultado) {
        echo "SE HA REALIZADO EL REGISTRO CORRECTAMENTE";
    } else {
        echo "NO SE HA REALIZADO EL REGISTRO";
    }
}

// Manejo de búsqueda
$busqueda = "";
if (isset($_REQUEST['buscar']) && !empty($_REQUEST['buscar'])) {
    $busqueda = strtoupper(mysqli_real_escape_string($conexion, $_REQUEST['buscar']));
}

$consulta = "SELECT * FROM tareas";
if (!empty($busqueda)) {
    // Corregir la consulta para que funcione correctamente
    $consulta .= " WHERE 
        UPPER(titulo) LIKE '%$busqueda%' OR 
        UPPER(tipo) LIKE '%$busqueda%' OR  
        UPPER(materia) LIKE '%$busqueda%' OR 
        UPPER(descripcion) LIKE '%$busqueda%' OR 
        UPPER(fecha_entrega) LIKE '%$busqueda%' OR 
        UPPER(estado) LIKE '%$busqueda%'";
}

$resultado = mysqli_query($conexion, $consulta) or die("No se ha podido mostrar la consulta: " . mysqli_error($conexion));

echo "<h1><b><u>TAREAS</u></b></h1>";
?>

<form action="ver.php" method="GET">
    <input type="text" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Buscar..."/>
    <input type="submit" value="Buscar"/>
</form>

<table border='1'>
    <tr>
        <th>ID</th>
        <th>TÍTULO</th>
        <th>TIPO</th>
        <th>MATERIA</th>
        <th>DESCRIPCIÓN</th>
        <th>FECHA DE ENTREGA</th>
        <th>ESTADO</th>
        <th>ACTUALIZAR</th>
        <th>ELIMINAR</th>
    </tr>

<?php
while ($columna = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $columna['id_tarea'] . "</td>";
    echo "<td>" . $columna['titulo'] . "</td>";
    echo "<td>" . $columna['tipo'] . "</td>";
    echo "<td>" . $columna['materia'] . "</td>";
    echo "<td>" . $columna['descripcion'] . "</td>";
    echo "<td>" . $columna['fecha_entrega'] . "</td>";
    echo "<td>" . $columna['estado'] . "</td>";
    $id_tarea = $columna['id_tarea'];
    echo "<td><a href='modificar.php?id_tarea=$id_tarea'>ACTUALIZAR</a></td>";
    echo "<td><a href='eliminar.php?id_tarea=$id_tarea'>ELIMINAR</a></td>";
    echo "</tr>";
}
?>
</table>
<form action="formulario_registro.php">
    <input type="submit" value="IR A FORMULARIO DE REGISTRO">
</form>
</body>
</html>