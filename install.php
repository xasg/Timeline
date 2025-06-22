<?php
// Installation script for ANUIES TIC Timeline System
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - ANUIES TIC Timeline</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #882642 0%, #c16c81 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .install-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #882642;
            text-align: center;
            margin-bottom: 30px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #882642;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .step h3 {
            color: #882642;
            margin-top: 0;
        }
        .code {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            background: #882642;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #c16c81;
        }
    </style>
</head>
<body>
    <div class="install-container">
        <h1>🚀 Instalación ANUIES TIC Timeline</h1>
        
        <div class="step">
            <h3>1. Configurar Base de Datos</h3>
            <p>Ejecutar el siguiente comando SQL para crear la base de datos:</p>
            <div class="code">mysql -u root -p &lt; database.sql</div>
            <p>O importar manualmente el archivo <code>database.sql</code> en phpMyAdmin/Workbench</p>
        </div>

        <div class="step">
            <h3>2. Configurar Conexión</h3>
            <p>Editar <code>config.php</code> con los datos de tu base de datos:</p>
            <div class="code">define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'anuies_tic');</div>
        </div>

        <div class="step">
            <h3>3. Permisos de Archivos</h3>
            <p>Configurar permisos para el directorio de uploads:</p>
            <div class="code">chmod 755 uploads/
chmod 644 uploads/.htaccess</div>
        </div>

        <div class="highlight">
            <strong>Credenciales de Acceso Administrativo:</strong><br>
            Usuario: <code>admin</code><br>
            Contraseña: <code>admin123</code><br>
            <small>⚠️ Cambiar estas credenciales en producción editando config.php</small>
        </div>

        <div class="success">
            <strong>✅ Sistema Listo</strong><br>
            El sistema incluye 10 elementos históricos pre-cargados del Comité ANUIES TIC
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" class="btn">🌐 Ver Timeline Público</a>
            <a href="login.php" class="btn">🔐 Acceso Admin</a>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #666;">
            <small>Sistema desarrollado para ANUIES TIC - 10 Años de Innovación</small>
        </div>
    </div>
</body>
</html>