<?php
session_start();

$mensaje_exito = '';
$mensaje_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    
    $con = new mysqli("localhost", "root", "", "mibase");
    if ($con->connect_error) {
        $mensaje_error = "Error de conexión con la base de datos.";
    } else {
        
        $nombre = trim($_POST['name']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['phone']);
        $contrasena = trim($_POST['password']);
        $rol = 'usuario';
        
        if (empty($nombre) || empty($email) || empty($contrasena)) {
            $mensaje_error = "Los campos Nombre, Email y Contraseña son obligatorios.";
        } else {
            
            $contrasena = $contrasena; 

            $stmt = $con->prepare("INSERT INTO usuarios (nombre, email, telefono, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nombre, $email, $telefono, $contrasena, $rol);

            if ($stmt->execute()) {
                $mensaje_exito = "¡Registro exitoso! Ya puedes <a href='index.php' class='font-bold underline'>iniciar sesión</a>.";
            } else {
                if ($con->errno == 1062) {
                    $mensaje_error = "El email ya está registrado. Intenta con otro.";
                } else {
                    $mensaje_error = "Error al registrar: " . $stmt->error;
                }
            }
            $stmt->close();
        }
        $con->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-5 bg-gray-100">
    
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        
        <div class="bg-indigo-600 text-white p-6 text-center">
            <h1 class="text-2xl font-bold mb-2">Registro de Usuario</h1>
            <p class="text-sm opacity-90">Completa tus datos para crear una cuenta</p>
        </div>
        
        <div class="p-8">

            <?php if ($mensaje_error): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border-l-4 border-red-500 font-semibold">
                    <?= htmlspecialchars($mensaje_error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($mensaje_exito): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border-l-4 border-green-500 font-semibold">
                    <?= $mensaje_exito ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="registro.php" class="space-y-5">
                <input type="hidden" name="registrar" value="1">
                
                <div>
                    <label for="name" class="block mb-2 font-semibold text-gray-700">Nombre completo</label>
                    <input type="text" id="name" name="name" placeholder="Ingresa tu nombre completo" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                </div>
                
                <div>
                    <label for="email" class="block mb-2 font-semibold text-gray-700">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                </div>
                
                <div>
                    <label for="password" class="block mb-2 font-semibold text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                </div>
                
                <div>
                    <label for="phone" class="block mb-2 font-semibold text-gray-700">Teléfono</label>
                    <input type="text" id="phone" name="phone" placeholder="Ej: 123 456 789" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 text-white p-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150"
                >
                    Crear Cuenta
                </button>
            </form>
            
            <div class="text-center mt-5 text-sm text-gray-600">
                ¿Ya tienes una cuenta? <a href="index.php" class="text-indigo-600 hover:text-indigo-800 font-medium">Inicia sesión</a>
            </div>
        </div>
    </div>
</body>
</html>