<h2 class="page-title">Configuración del Sistema</h2>

<div class="card">
    <div class="card-header">
        <h3>Configuración General</h3>
    </div>
    <div class="card-body">
        <form method="POST" class="settings-form">
            <input type="hidden" name="action" value="save_settings">
            
            <div class="settings-grid">
                <div class="setting-group">
                    <label for="site_title">Título del Sitio</label>
                    <input type="text" id="site_title" name="settings[site_title]" 
                           value="<?php echo htmlspecialchars($settings['site_title'] ?? '10 AÑOS ANUIES TIC'); ?>"
                           class="form-control">
                </div>

                <div class="setting-group">
                    <label for="site_description">Descripción del Sitio</label>
                    <textarea id="site_description" name="settings[site_description]" 
                              class="form-control" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? 'Una década de innovación y colaboración en la educación superior mexicana'); ?></textarea>
                </div>

                <div class="setting-group">
                    <label for="admin_email">Email del Administrador</label>
                    <input type="email" id="admin_email" name="settings[admin_email]" 
                           value="<?php echo htmlspecialchars($settings['admin_email'] ?? ''); ?>"
                           class="form-control">
                </div>

                <div class="setting-group">
                    <label for="items_per_page">Elementos por Página</label>
                    <input type="number" id="items_per_page" name="settings[items_per_page]" 
                           value="<?php echo htmlspecialchars($settings['items_per_page'] ?? '10'); ?>"
                           min="5" max="50" class="form-control">
                </div>

                <div class="setting-group">
                    <label for="youtube_api_key">API Key de YouTube (opcional)</label>
                    <input type="text" id="youtube_api_key" name="settings[youtube_api_key]" 
                           value="<?php echo htmlspecialchars($settings['youtube_api_key'] ?? ''); ?>"
                           class="form-control">
                    <small class="form-text">Para obtener información automática de videos de YouTube</small>
                </div>

                <div class="setting-group">
                    <label for="default_image">Imagen por Defecto (URL)</label>
                    <input type="url" id="default_image" name="settings[default_image]" 
                           value="<?php echo htmlspecialchars($settings['default_image'] ?? ''); ?>"
                           class="form-control">
                    <small class="form-text">Imagen que se mostrará cuando no hay imagen específica</small>
                </div>
            </div>

            <div class="setting-group">
                <h4>Configuración de Contenido</h4>
                
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="settings[allow_youtube_embed]" value="1"
                               <?php echo ($settings['allow_youtube_embed'] ?? '1') == '1' ? 'checked' : ''; ?>>
                        Permitir embebido de videos de YouTube
                    </label>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="settings[auto_publish]" value="1"
                               <?php echo ($settings['auto_publish'] ?? '0') == '1' ? 'checked' : ''; ?>>
                        Publicar elementos automáticamente
                    </label>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="settings[enable_comments]" value="1"
                               <?php echo ($settings['enable_comments'] ?? '0') == '1' ? 'checked' : ''; ?>>
                        Habilitar comentarios (funcionalidad futura)
                    </label>
                </div>
            </div>

            <div class="setting-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar Configuración</button>
                <button type="button" onclick="resetToDefaults()" class="btn">🔄 Restaurar Valores por Defecto</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Información del Sistema</h3>
    </div>
    <div class="card-body">
        <div class="system-info">
            <div class="info-item">
                <strong>Versión PHP:</strong> <?php echo PHP_VERSION; ?>
            </div>
            <div class="info-item">
                <strong>Versión MySQL:</strong> 
                <?php 
                try {
                    $version = $GLOBALS['pdo']->query('SELECT VERSION()')->fetchColumn();
                    echo htmlspecialchars($version);
                } catch(Exception $e) {
                    echo 'No disponible';
                }
                ?>
            </div>
            <div class="info-item">
                <strong>Espacio en Disco:</strong> 
                <?php 
                $bytes = disk_free_space('.');
                echo $bytes ? number_format($bytes / 1024 / 1024 / 1024, 2) . ' GB disponibles' : 'No disponible';
                ?>
            </div>
            <div class="info-item">
                <strong>Límite de Memoria PHP:</strong> <?php echo ini_get('memory_limit'); ?>
            </div>
            <div class="info-item">
                <strong>Límite de Subida:</strong> <?php echo ini_get('upload_max_filesize'); ?>
            </div>
        </div>
    </div>
</div>

<script>
function resetToDefaults() {
    if (confirm('¿Estás seguro de restaurar todos los valores por defecto? Esta acción no se puede deshacer.')) {
        document.getElementById('site_title').value = '10 AÑOS ANUIES TIC';
        document.getElementById('site_description').value = 'Una década de innovación y colaboración en la educación superior mexicana';
        document.getElementById('admin_email').value = '';
        document.getElementById('items_per_page').value = '10';
        document.getElementById('youtube_api_key').value = '';
        document.getElementById('default_image').value = '';
        
        // Reset checkboxes
        document.querySelector('input[name="settings[allow_youtube_embed]"]').checked = true;
        document.querySelector('input[name="settings[auto_publish]"]').checked = false;
        document.querySelector('input[name="settings[enable_comments]"]').checked = false;
    }
}
</script>

<style>
.settings-form {
    max-width: 800px;
}

.settings-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.setting-group {
    margin-bottom: 20px;
}

.setting-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--text-color);
}

.setting-group h4 {
    color: var(--primary-color);
    margin-bottom: 15px;
    padding-bottom: 5px;
    border-bottom: 2px solid var(--primary-color);
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(136, 38, 66, 0.2);
}

.form-text {
    color: #666;
    font-size: 0.85rem;
    margin-top: 3px;
}

.checkbox-group {
    margin: 10px 0;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-weight: normal;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
}

.setting-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.system-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.info-item {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
}

@media screen and (max-width: 768px) {
    .settings-grid,
    .system-info {
        grid-template-columns: 1fr;
    }
    
    .setting-actions {
        flex-direction: column;
    }
}
</style>