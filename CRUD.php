<?php
session_start();

//Si no hay sesión, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Index.php");
    exit();
}

// si el rol no es administrador, redirigir
if ($_SESSION['usuario_rol'] !== 'administrador') {
    header("Location: Pagina_usuarios.php"); 
    exit();
}


/* Conexión a la base de datos */
$con = new mysqli("localhost", "root", "", "mibase");
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

$seccion_activa = "lista";
$buscado = null;
$editar = null;
$eliminar = null;
$mensaje = "";
$datos_lista = null;

/*Buscar usuario*/
function buscar($con, $id) {
    // Se añade 'contrasena' a la búsqueda para actualizar y eliminar
    $stmt = $con->prepare("SELECT * FROM usuarios WHERE id = ?"); 
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
    return ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
}

/*Insertar*/
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    // CAMBIO: Se captura la contraseña ingresada por el administrador
    $contrasena = $_POST['contrasena']; 

    // $contrasena_default se elimina
    $rol_default = 'usuario';

    $stmt = $con->prepare("INSERT INTO usuarios (nombre, email, telefono, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
    // CAMBIO: Se usa $contrasena en bind_param
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $contrasena, $rol_default); 

    if ($stmt->execute()) {
        // CAMBIO: Mensaje indica la contraseña ingresada
        $mensaje = "Usuario registrado correctamente con rol 'usuario' (contraseña: " . htmlspecialchars($contrasena) . ").";
    } else {
        $mensaje = "Error al registrar: " . $stmt->error;
    }
    $stmt->close();
    $seccion_activa = "lista"; 
}

/*Buscar*/
if (isset($_POST['buscar'])) {
    $buscado = buscar($con, $_POST['id']);
    if (!$buscado) $mensaje = "Usuario con ID " . $_POST['id'] . " no encontrado.";
    $seccion_activa = "buscar"; 
}

/*Cargar datos para actualizar*/
if (isset($_POST['cargar_actualizar'])) {
    $editar = buscar($con, $_POST['id']);
    if (!$editar) $mensaje = "Usuario con ID " . $_POST['id'] . " no encontrado para actualizar.";
    $seccion_activa = "actualizar";
}

/*Actualizar*/
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $stmt = $con->prepare("UPDATE usuarios SET nombre=?, email=?, telefono=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $email, $telefono, $id);

    if ($stmt->execute()) {
        $mensaje = "Usuario $id actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar: " . $stmt->error;
    }
    $stmt->close();
    $seccion_activa = "lista"; 
}

/*Cargar datos para eliminar*/
if (isset($_POST['cargar_eliminar'])) {
    $eliminar = buscar($con, $_POST['id']);
    if (!$eliminar) $mensaje = "Usuario con ID " . $_POST['id'] . " no encontrado para eliminar.";
    $seccion_activa = "eliminar"; 
}

/*Eliminar*/
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $mensaje = "Usuario $id eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
    $seccion_activa = "lista"; 
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Administrador</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100 min-h-screen">

<div class="flex justify-center gap-4 bg-blue-500 p-4 shadow-md">
    <span class="cursor-pointer text-white bg-blue-700 px-4 py-2 rounded-lg font-bold hover:bg-blue-600 transition duration-150" onclick="mostrar('crear')">Insertar</span>
    <span class="cursor-pointer text-white bg-blue-700 px-4 py-2 rounded-lg font-bold hover:bg-blue-600 transition duration-150" onclick="mostrar('buscar')">Buscar</span>
    <span class="cursor-pointer text-white bg-blue-700 px-4 py-2 rounded-lg font-bold hover:bg-blue-600 transition duration-150" onclick="mostrar('actualizar')">Actualizar</span>
    <span class="cursor-pointer text-white bg-blue-700 px-4 py-2 rounded-lg font-bold hover:bg-blue-600 transition duration-150" onclick="mostrar('eliminar')">Eliminar</span>
    <a href="logout.php" class="text-white bg-red-600 px-4 py-2 rounded-lg font-bold hover:bg-red-700 transition duration-150">Cerrar Sesión</a>
</div>

<div class="w-11/12 max-w-5xl mx-auto my-6">

<?php
//Mostrar mensaje de estado
if ($mensaje) {
    echo "<p class='p-3 rounded-lg bg-green-100 border-l-4 border-green-500 text-green-700 font-semibold mb-6'>" . $mensaje . "</p>";
}

// CAMBIO: Se añade 'contrasena' a la consulta SELECT para listarla
$datos_lista = $con->query("SELECT id, nombre, email, telefono, contrasena, rol FROM usuarios ORDER BY id DESC"); 
?>

<div id="crear" class="tarjeta bg-white p-6 rounded-xl shadow-lg mb-6 hidden">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Crear Usuario</h2>
    <form method="POST" class="flex flex-col space-y-4">
        <input type="text" name="nombre" placeholder="Nombre" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="email" name="email" placeholder="Email" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="text" name="telefono" placeholder="Teléfono" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="text" name="contrasena" placeholder="Contraseña para el usuario" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="submit" name="crear" value="Registrar" class="bg-blue-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-blue-700 transition duration-150">
    </form>
</div>

<div id="buscar" class="tarjeta bg-white p-6 rounded-xl shadow-lg mb-6 hidden">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Buscar Usuario</h2>
    <form method="POST" class="flex flex-col space-y-4">
        <input type="number" name="id" placeholder="ID" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="submit" name="buscar" value="Buscar" class="bg-blue-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-blue-700 transition duration-150">
    </form>

    <?php if($buscado): ?>
    <div class="mt-6 pt-4 border-t border-gray-200">
        <p class="mb-2"><b>Id:</b> <?=htmlspecialchars($buscado['id'])?></p>
        <p class="mb-2"><b>Nombre:</b> <?=htmlspecialchars($buscado['nombre'])?></p>
        <p class="mb-2"><b>Email:</b> <?=htmlspecialchars($buscado['email'])?></p>
        <p class="mb-2"><b>Teléfono:</b> <?=htmlspecialchars($buscado['telefono'])?></p>
        <p class="mb-2"><b>Contraseña:</b> <?=htmlspecialchars($buscado['contrasena'])?></p>
        <p class="mb-2"><b>Rol:</b> <?=htmlspecialchars($buscado['rol'])?></p>
    </div>
    <?php endif; ?>
</div>

<div id="actualizar" class="tarjeta bg-white p-6 rounded-xl shadow-lg mb-6 hidden">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Actualizar Usuario</h2>

    <form method="POST" class="flex flex-col space-y-4">
        <input type="number" name="id" placeholder="ID a modificar" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="submit" name="cargar_actualizar" value="Cargar Datos" class="bg-blue-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-blue-700 transition duration-150">
    </form>

    <?php if($editar): ?>
    <h4 class="mt-6 mb-4 text-xl font-semibold">Datos del usuario: <?=$editar['id']?></h4>
    <form method="POST" class="flex flex-col space-y-4">
        <input type="hidden" name="id" value="<?=htmlspecialchars($editar['id'])?>">
        <input type="text" name="nombre" value="<?=htmlspecialchars($editar['nombre'])?>" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="email" name="email" value="<?=htmlspecialchars($editar['email'])?>" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="text" name="telefono" value="<?=htmlspecialchars($editar['telefono'])?>" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="submit" name="actualizar" value="Actualizar" class="bg-blue-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-blue-700 transition duration-150">
    </form>
    <?php endif; ?>
</div>

<div id="eliminar" class="tarjeta bg-white p-6 rounded-xl shadow-lg mb-6 hidden">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Eliminar Usuario</h2>

    <form method="POST" class="flex flex-col space-y-4">
        <input type="number" name="id" placeholder="ID a eliminar" required class="p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        <input type="submit" name="cargar_eliminar" value="Cargar" class="bg-blue-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-blue-700 transition duration-150">
    </form>

    <?php if($eliminar): ?>
    <div class="mt-6 pt-4 border-t border-gray-200">
        <form method="POST" class="flex flex-col space-y-4">
            <h3 class="text-lg font-medium text-red-600">¿Eliminar permanentemente al usuario <b><?=htmlspecialchars($eliminar['nombre'])?></b>?</h3>
            <input type="hidden" name="id" value="<?=htmlspecialchars($eliminar['id'])?>">
            <input type="submit" name="eliminar" value="Eliminar Confirmar" class="bg-red-600 text-white p-3 rounded-lg font-bold cursor-pointer hover:bg-red-700 transition duration-150">
        </form>
    </div>
    <?php endif; ?>
</div>

<div id="lista" class="tarjeta bg-white p-6 rounded-xl shadow-lg mb-6">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Lista de Usuarios</h2>
    <table class="w-full border-collapse mt-4">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="border border-blue-400 p-3 text-left">ID</th>
                <th class="border border-blue-400 p-3 text-left">Nombre</th>
                <th class="border border-blue-400 p-3 text-left">Email</th>
                <th class="border border-blue-400 p-3 text-left">Teléfono</th>
                <th class="border border-blue-400 p-3 text-left">Contraseña</th>
                <th class="border border-blue-400 p-3 text-left">Rol</th>
            </tr>
        </thead>
        <tbody>
        <?php if($datos_lista && $datos_lista->num_rows > 0): 
            while($usuario = $datos_lista->fetch_assoc()):
            ?>
                <tr class="even:bg-gray-50 hover:bg-blue-50 transition duration-100">
                    <td class="border border-gray-200 p-3"><?=htmlspecialchars($usuario['id'])?></td>
                    <td class="border border-gray-200 p-3"><?=htmlspecialchars($usuario['nombre'])?></td>
                    <td class="border border-gray-200 p-3"><?=htmlspecialchars($usuario['email'])?></td>
                    <td class="border border-gray-200 p-3"><?=htmlspecialchars($usuario['telefono'])?></td>
                    <td class="border border-gray-200 p-3 font-mono text-xs"><?=htmlspecialchars($usuario['contrasena'])?></td> 
                    <td class="border border-gray-200 p-3 font-semibold <?=($usuario['rol'] == 'administrador' ? 'text-red-500' : 'text-green-600')?>"><?=htmlspecialchars($usuario['rol'])?></td>
                </tr>
            <?php endwhile; 
            else: ?>
            <tr><td colspan='6' class='border border-gray-200 p-3 text-center text-gray-500'>Sin datos de usuarios en la base de datos.</td></tr>
        <?php endif; ?>
        <?php 
        //Cierra la conexión al final de la renderización de datos
        $con->close(); 
        ?>
        </tbody>
    </table>
</div>

<script>
function mostrar(seccion){
    //Utiliza el selector de clases 'tarjeta' y cambia a 'hidden'
    document.querySelectorAll('.tarjeta').forEach(t=>t.classList.add('hidden'));
    //Muestra la sección deseada
    document.getElementById(seccion).classList.remove('hidden');
}

window.onload = ()=>{ mostrar("<?= $seccion_activa ?>"); };
</script>

</body>
</html>
