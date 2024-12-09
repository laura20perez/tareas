<?php
// Llamar al archivo de conexión.
include("conexion.php");

$existe_registro = false;

if (
    isset($_REQUEST['id_tarea']) && !empty($_REQUEST['id_tarea']) &&
    isset($_REQUEST['titulo']) && !empty($_REQUEST['titulo']) &&
    isset($_REQUEST['materia']) && !empty($_REQUEST['materia']) &&
    isset($_REQUEST['descripcion']) && !empty($_REQUEST['descripcion']) &&
    isset($_REQUEST['fecha_entrega']) && !empty($_REQUEST['fecha_entrega']) &&
    isset($_REQUEST['estado']) && !empty($_REQUEST['estado']) &&
    isset($_REQUEST['tipo']) && !empty($_REQUEST['tipo'])
) {
    $id_tarea = $_REQUEST['id_tarea'];
    $titulo = strtoupper($_REQUEST['titulo']); // Convertir a mayúsculas
    $materia = strtoupper($_REQUEST['materia']); // Convertir a mayúsculas
    $descripcion = strtoupper($_REQUEST['descripcion']); // Convertir a mayúsculas
    $fecha_entrega = $_REQUEST['fecha_entrega'];
    $estado = strtoupper($_REQUEST['estado']); // Convertir a mayúsculas
    $tipo = strtoupper($_REQUEST['tipo']); // Convertir a mayúsculas para el tipo
    $existe_registro = true;
}

// Creación de la conexión con el servidor
$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("No se ha podido establecer conexión con el servidor: " . $conexion->connect_error);
}

// Código para actualizar el registro en la tabla tareas
if ($existe_registro) {
    $consulta = "UPDATE tareas SET 
        titulo = ?, 
        tipo = ?, 
        materia = ?, 
        descripcion = ?, 
        fecha_entrega = ?, 
        estado = ?
        WHERE id_tarea = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular parámetros en el mismo orden de los campos
        $stmt->bind_param("ssssssi", $titulo, $tipo, $materia, $descripcion, $fecha_entrega, $estado, $id_tarea);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de visualización después de la actualización
            header("Location: ver.php?mensaje=modificado");
            exit; // Asegura que no se ejecute más código después de la redirección
        } else {
            echo "NO SE HA REALIZADO LA MODIFICACIÓN: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>