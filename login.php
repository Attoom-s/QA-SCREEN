<?php
session_start();
$jsonFile = 'data/usuarios.json';
$mensaje = '';
$tipoAlerta = '';

function cargarUsuarios($file) {
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'login') {
        $user = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';
        $usuarios = cargarUsuarios($jsonFile);

        if (isset($usuarios[$user]) && $usuarios[$user]['password'] === $pass) {
            $_SESSION['usuario'] = $user;
            $_SESSION['nombre'] = $usuarios[$user]['nombre'];
            $_SESSION['rol'] = $usuarios[$user]['rol'];
            
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Credenciales incorrectas. Verifique usuario y contraseña.";
            $tipoAlerta = "bg-red-100 text-red-700";
        }
    }

    if ($accion === 'registro') {
        $user = trim($_POST['reg_username'] ?? '');
        $pass = $_POST['reg_password'] ?? '';
        $nombre = trim($_POST['reg_nombre'] ?? '');
        
        if (!empty($user) && !empty($pass) && !empty($nombre)) {
            $usuarios = cargarUsuarios($jsonFile);
            
            if (isset($usuarios[$user])) {
                $mensaje = "El nombre de usuario ya existe.";
                $tipoAlerta = "bg-amber-100 text-amber-700";
            } else {
                $usuarios[$user] = [
                    "password" => $pass,
                    "nombre" => "Tester: " . $nombre,
                    "rol" => "CLIENTE",
                    "fechaRegistro" => date("Y-m-d H:i:s")
                ];
                
                if (!file_exists('data')) {
                    mkdir('data', 0777, true);
                }

                file_put_contents($jsonFile, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $mensaje = "¡Registro exitoso! Ya puede iniciar sesión.";
                $tipoAlerta = "bg-emerald-100 text-emerald-700";
            }
        } else {
            $mensaje = "Complete todos los campos del registro.";
            $tipoAlerta = "bg-red-100 text-red-700";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Acceso QA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-slate-800 rounded-2xl shadow-xl border border-slate-700 overflow-hidden">
        <div class="bg-purple-900 p-6 text-center border-b border-purple-800">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-800 text-amber-400 mb-2 border border-amber-500/30">
                <i class="fa-solid fa-vial-circle-check text-xl"></i>
            </div>
            <h1 class="text-xl font-bold text-white">Portal de Autenticación QA</h1>
            <p class="text-xs text-purple-200 mt-1">Gestión de Testers y Roles (Admin / Cliente)</p>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="p-4 m-4 text-xs font-semibold rounded-lg <?= $tipoAlerta ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <div class="flex border-b border-slate-700 text-xs font-semibold">
            <button onclick="switchTab('login')" id="btn-login" class="flex-1 py-3 text-center text-purple-400 border-b-2 border-purple-500 bg-slate-800/50 transition">Iniciar Sesión</button>
            <button onclick="switchTab('registro')" id="btn-registro" class="flex-1 py-3 text-center text-slate-400 hover:text-slate-200 transition">Registrar Tester</button>
        </div>

        <div id="form-login" class="p-6">
            <form action="login.php" method="POST" class="space-y-4">
                <input type="hidden" name="accion" value="login">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Usuario</label>
                    <input type="text" name="username" required placeholder="ej. admin o tester_qa" class="w-full p-2.5 bg-slate-900 border border-slate-700 rounded-lg text-sm focus:border-purple-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full p-2.5 bg-slate-900 border border-slate-700 rounded-lg text-sm focus:border-purple-500 focus:outline-none">
                </div>
                <button type="submit" class="w-full py-3 bg-purple-700 hover:bg-purple-600 text-white rounded-lg text-sm font-bold transition shadow-lg">
                    Ingresar al Dashboard
                </button>
            </form>
            <div class="mt-4 text-[11px] text-slate-500 text-center">
                Admin: <code class="text-purple-300">admin</code> / <code class="text-purple-300">1234</code><br>
                Tester: <code class="text-purple-300">tester_qa</code> / <code class="text-purple-300">test2026</code>
            </div>
        </div>

        <div id="form-registro" class="p-6 hidden">
            <form action="login.php" method="POST" class="space-y-4">
                <input type="hidden" name="accion" value="registro">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre / Alias del Tester</label>
                    <input type="text" name="reg_nombre" required placeholder="ej. Carlos Pérez" class="w-full p-2.5 bg-slate-900 border border-slate-700 rounded-lg text-sm focus:border-purple-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre de Usuario (Login)</label>
                    <input type="text" name="reg_username" required placeholder="ej. tester02" class="w-full p-2.5 bg-slate-900 border border-slate-700 rounded-lg text-sm focus:border-purple-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Contraseña</label>
                    <input type="password" name="reg_password" required placeholder="••••••••" class="w-full p-2.5 bg-slate-900 border border-slate-700 rounded-lg text-sm focus:border-purple-500 focus:outline-none">
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold transition shadow-lg">
                    Registrarse como Tester (Cliente)
                </button>
            </form>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            const loginDiv = document.getElementById('form-login');
            const regDiv = document.getElementById('form-registro');
            const btnLogin = document.getElementById('btn-login');
            const btnReg = document.getElementById('btn-registro');

            if (tab === 'login') {
                loginDiv.classList.remove('hidden');
                regDiv.classList.add('hidden');
                btnLogin.classList.add('border-b-2', 'border-purple-500', 'text-purple-400', 'bg-slate-800/50');
                btnReg.classList.remove('border-b-2', 'border-purple-500', 'text-purple-400', 'bg-slate-800/50');
                btnReg.classList.add('text-slate-400');
            } else {
                regDiv.classList.remove('hidden');
                loginDiv.classList.add('hidden');
                btnReg.classList.add('border-b-2', 'border-purple-500', 'text-purple-400', 'bg-slate-800/50');
                btnLogin.classList.remove('border-b-2', 'border-purple-500', 'text-purple-400', 'bg-slate-800/50');
                btnLogin.classList.add('text-slate-400');
            }
        }
    </script>
</body>
</html>