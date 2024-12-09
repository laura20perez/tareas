<html>
<head>
    <title>FORMULARIO DE REGISTRO</title>
    <style>
        input[type="text"], textarea {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<form action="ver.php" method="POST">
    <fieldset>
        <legend><b>FORMULARIO DE REGISTRO</b></legend>
        <label>Título:</label>
        <input type="text" name="titulo" required/><br>
        <label>Materia:</label>
        <input type="text" name="materia" required/><br>
        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea><br>
        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="PROYECTO">PROYECTO</option>
            <option value="PRESENTACION">PRESENTACIÓN</option>
            <option value="PRACTICA">PRÁCTICA</option>
            <option value="INVESTIGACION">INVESTIGACIÓN</option>
            <option value="ENSAYO">ENSAYO</option>
            <option value="EXAMEN">EXAMEN</option>
            <option value="OTROS">OTROS</option>
        </select><br>
        <label>Fecha de entrega:</label>
        <input type="date" name="fecha_entrega" required/><br>
        <label>Estado:</label>
        <select name="estado" required>
            <option value="INCOMPLETO">INCOMPLETO</option>
            <option value="COMPLETO">COMPLETO</option>
        </select><br>
        <input type="submit" value="REGISTRAR">
        <input type="reset" value="BORRAR">
    </fieldset>
</form>
<form action="ver.php">
    <input type="submit" value="VER TAREAS">
</form>
</body>
</html>
