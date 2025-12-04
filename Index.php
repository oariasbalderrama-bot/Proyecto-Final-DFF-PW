<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['usuario_rol'] === 'administrador') {
        header("Location: CRUD.php");
    } else {
        header("Location: Pagina_usuarios.php"); 
    }
    exit();
}

$mensaje_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    
    $con = new mysqli("localhost", "root", "", "mibase");
    if ($con->connect_error) {
        // Esto detiene el script y previene la redirección si la base de datos falla
        die("Error de conexión: " . $con->connect_error);
    }

    $email = trim($_POST['email']);
    $contrasena = trim($_POST['password']);
    
    $stmt = $con->prepare("SELECT id, nombre, contrasena, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();
    $con->close();

    if ($usuario && $contrasena === $usuario['contrasena']) {
        
        //Login Exitoso
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        
        if ($usuario['rol'] === 'administrador') {
            header("Location: CRUD.php");
        } else {
            header("Location: Pagina_usuarios.php");
        }
        exit();
        
    } else {
        $mensaje_error = "Email o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-5 bg-gray-100">
    
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        
        <div class="bg-indigo-600 text-white p-6 text-center">
            <h1 class="text-2xl font-bold mb-2">Iniciar Sesión</h1>
            <p class="text-sm opacity-90">Ingresa tus credenciales</p>
        </div>
        
        <div class="p-8">
            
            <?php if ($mensaje_error): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border-l-4 border-red-500 font-semibold">
                    <?= htmlspecialchars($mensaje_error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php" class="space-y-5">
                <input type="hidden" name="login" value="1">

                <div class="form-group">
                    <label for="email" class="block mb-2 font-semibold text-gray-700">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        placeholder="ejemplo@correo.com"
                        required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="block mb-2 font-semibold text-gray-700">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                    >
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 text-white p-3 rounded-lg font-bold hover:bg-indigo-700 transition duration-150"
                >
                    Acceder
                </button>
            </form>
            
            <div class="text-center mt-5 text-sm text-gray-600">
                ¿Aún no tienes cuenta? <a href="registro.php" class="text-indigo-600 hover:text-indigo-800 font-medium">Regístrate aquí</a>
            </div>
        </div>
    </div>
</body>
</html>