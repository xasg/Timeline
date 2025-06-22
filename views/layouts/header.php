<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? '10 AÑOS ANUIES TIC'; ?></title>
    <meta name="description" content="<?php echo $pageDescription ?? 'Una década de innovación y colaboración en la educación superior mexicana - Comité ANUIES TIC'; ?>">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="w-full max-w-4xl flex items-center justify-center">
            <img 
                src="assets/images/LogosANUIES-TIC.png" 
                alt="Logos ANUIES TIC - 75 Años, 10° Aniversario, MetaRedTIC" 
                style="height: 80px; width: auto; object-fit: contain; max-height: 80px;"
                onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'background-color: rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 15px 25px;\'><span style=\'font-size: 18px; font-weight: bold;\'>ANUIES TIC - 10 AÑOS</span></div>';"
            />
        </div>
        <?php if (isset($showAdminBtn) && $showAdminBtn): ?>
            <a href="login.php" class="admin-btn">👤 Admin</a>
        <?php endif; ?>
    </header>