<?php
// Llamar al archivo de conexión.
include("conexion.php");

$existe_registro = false;

// Validar si 'id_tarea' está presente y es un número entero
if (isset($_REQUEST['id_tarea']) && filter_var($_REQUEST['id_tarea'], FILTER_VALIDATE_INT)) {
    $id_tarea = $_REQUEST['id_tarea'];
    $existe_registro = true;
}

// Crear conexión con el servidor y base de datos
$conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

// Verificar la conexión
if (!$conexion) {
    die("No se ha podido establecer conexión con el servidor: " . mysqli_connect_error());
}

// Código para eliminar el registro de la tabla tareas
if ($existe_registro) {
    // Usar una consulta preparada para mayor seguridad
    $consulta = "DELETE FROM tareas WHERE id_tarea = ?";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_tarea); // 'i' indica tipo entero
        $resultado = mysqli_stmt_execute($stmt);

        if ($resultado) {
            // Redirigir a ver.php con el mensaje 'eliminado'
            header("Location: ver.php?mensaje=eliminado");
            exit; // Detener la ejecución del script después de la redirección
        } else {
            echo "NO SE HA REALIZADO LA ELIMINACIÓN: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt); // Cerrar el statement
    } else {
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }
} else {
    echo "El parámetro 'id_tarea' no es válido o no fue proporcionado.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
