<?php
$pageTitle = 'Panel de Administración - ANUIES TIC';
$additionalScripts = ['assets/js/admin.js'];
include 'views/layouts/admin_header.php';
?>

<div class="main-container">
    <nav class="sidebar">
        <a href="?view=dashboard" class="nav-item <?php echo $view === 'dashboard' ? 'active' : ''; ?>">
            📊 Dashboard
        </a>
        <a href="?view=timeline" class="nav-item <?php echo $view === 'timeline' ? 'active' : ''; ?>">
            📅 Gestionar Timeline
        </a>
        <a href="?view=media" class="nav-item <?php echo $view === 'media' ? 'active' : ''; ?>">
            🖼 Gestión de Medios
        </a>
        <a href="?view=settings" class="nav-item <?php echo $view === 'settings' ? 'active' : ''; ?>">
            ⚙ Configuración
        </a>
    </nav>

    <main class="content">
        <?php if (isset($message) && $message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (isset($error) && $error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php 
        switch($view) {
            case 'dashboard':
                include 'views/admin/dashboard.php';
                break;
            case 'timeline':
                include 'views/admin/timeline.php';
                break;
            case 'media':
                include 'views/admin/media.php';
                break;
            case 'settings':
                include 'views/admin/settings.php';
                break;
            default:
                include 'views/admin/dashboard.php';
        }
        ?>
    </main>
</div>

<?php include 'views/layouts/admin_footer.php'; ?>