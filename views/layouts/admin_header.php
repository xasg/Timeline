<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Panel de Administración - ANUIES TIC'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body style="background-color: #f5f5f5; min-height: 100vh; display: flex; flex-direction: column;">
    <header style="background-color: var(--primary-color); color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 40px; height: 30px; background-color: rgba(255, 255, 255, 0.2); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold;">AT</div>
            <div>
                <h1 style="font-size: 1.2rem; margin: 0;">Panel de Administración</h1>
                <small>10 AÑOS ANUIES TIC</small>
            </div>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="index.php" class="btn" style="background-color: rgba(255, 255, 255, 0.1); color: white; border: 1px solid rgba(255, 255, 255, 0.3); text-decoration: none;">👁 Ver Público</a>
            <a href="logout.php" class="btn btn-danger" style="text-decoration: none;">🚪 Cerrar Sesión</a>
        </div>
    </header>