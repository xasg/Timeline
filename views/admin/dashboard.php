<h2 class="page-title">Dashboard</h2>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['eventos'] ?? 0; ?></div>
        <div class="stat-label">Eventos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['proyectos'] ?? 0; ?></div>
        <div class="stat-label">Proyectos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['publicaciones'] ?? 0; ?></div>
        <div class="stat-label">Publicaciones</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $totalItems ?? 0; ?></div>
        <div class="stat-label">Total de Elementos</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Actividad Reciente</h3>
    </div>
    <div class="card-body">
        <p>Sistema funcionando correctamente. Todos los elementos del timeline están disponibles para visualización pública.</p>
    </div>
</div>