<h2 class="page-title">Gestión de Medios</h2>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $mediaStats['total_files'] ?? 0; ?></div>
        <div class="stat-label">Total de Archivos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $mediaStats['images'] ?? 0; ?></div>
        <div class="stat-label">Imágenes</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo $mediaStats['videos'] ?? 0; ?></div>
        <div class="stat-label">Videos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo number_format(($mediaStats['total_size'] ?? 0) / 1024 / 1024, 2); ?> MB</div>
        <div class="stat-label">Espacio Usado</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Subir Nuevo Archivo</h3>
    </div>
    <div class="card-body">
        <div class="upload-section">
            <form method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="hidden" name="action" value="upload_media">
                <div class="form-group">
                    <label for="media_file">Seleccionar Archivo</label>
                    <input type="file" id="media_file" name="media_file" 
                           accept="image/*,video/*,.pdf" required
                           class="form-control">
                    <small class="form-text">Tipos permitidos: JPG, PNG, GIF, MP4, PDF (máximo 10MB)</small>
                </div>
                <button type="submit" class="btn btn-primary">📤 Subir Archivo</button>
            </form>
            
            <div class="url-helper">
                <h4>Usar Enlaces Externos</h4>
                <p>También puedes usar URLs externas para imágenes en los elementos del timeline:</p>
                <ul>
                    <li><strong>Imágenes:</strong> https://example.com/image.jpg</li>
                    <li><strong>YouTube:</strong> https://youtube.com/watch?v=VIDEO_ID</li>
                    <li><strong>Unsplash:</strong> https://images.unsplash.com/photo-ID</li>
                </ul>
                <p><a href="test_upload.php" target="_blank" style="color: var(--primary-color);">🔧 Probar funcionalidad de subida</a></p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Archivos Subidos</h3>
    </div>
    <div class="card-body">
        <?php if (empty($mediaFiles)): ?>
            <p class="no-files">No hay archivos subidos aún.</p>
        <?php else: ?>
            <div class="media-grid">
                <?php foreach ($mediaFiles as $file): ?>
                    <div class="media-item">
                        <div class="media-preview">
                            <?php if ($file['file_type'] === 'image'): ?>
                                <img src="<?php echo htmlspecialchars($file['file_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($file['original_name']); ?>">
                            <?php elseif ($file['file_type'] === 'video'): ?>
                                <video controls>
                                    <source src="<?php echo htmlspecialchars($file['file_path']); ?>" 
                                            type="<?php echo htmlspecialchars($file['mime_type']); ?>">
                                </video>
                            <?php else: ?>
                                <div class="file-icon">📄</div>
                            <?php endif; ?>
                        </div>
                        <div class="media-info">
                            <h4><?php echo htmlspecialchars($file['original_name']); ?></h4>
                            <p class="file-details">
                                Tipo: <?php echo htmlspecialchars($file['file_type']); ?><br>
                                Tamaño: <?php echo number_format($file['file_size'] / 1024, 2); ?> KB<br>
                                Subido: <?php echo date('d/m/Y H:i', strtotime($file['uploaded_at'])); ?>
                            </p>
                            <div class="media-actions">
                                <button onclick="copyToClipboard('<?php echo htmlspecialchars($file['file_path']); ?>')" 
                                        class="btn btn-sm">📋 Copiar URL</button>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('¿Estás seguro de eliminar este archivo?')">
                                    <input type="hidden" name="action" value="delete_media">
                                    <input type="hidden" name="media_id" value="<?php echo $file['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑 Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(window.location.origin + '/' + text).then(function() {
        alert('URL copiada al portapapeles');
    });
}
</script>

<style>
.upload-form {
    max-width: 500px;
}

.upload-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    align-items: start;
}

.url-helper {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
}

.url-helper h4 {
    color: var(--primary-color);
    margin-bottom: 10px;
}

.url-helper ul {
    margin-left: 20px;
}

.url-helper li {
    margin-bottom: 5px;
}

@media screen and (max-width: 768px) {
    .upload-section {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--text-color);
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-text {
    color: #666;
    font-size: 0.85rem;
    margin-top: 3px;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.media-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
}

.media-preview {
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.media-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.media-preview video {
    max-width: 100%;
    max-height: 100%;
}

.file-icon {
    font-size: 3rem;
    color: #666;
}

.media-info {
    padding: 15px;
}

.media-info h4 {
    margin: 0 0 10px 0;
    font-size: 1rem;
    color: var(--primary-color);
}

.file-details {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 10px;
}

.media-actions {
    display: flex;
    gap: 5px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.8rem;
}

.no-files {
    text-align: center;
    color: #666;
    padding: 40px;
}
</style>