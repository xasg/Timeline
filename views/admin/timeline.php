<h2 class="page-title">Gestión del Timeline</h2>

<div class="card">
    <div class="card-header">
        <h3>Agregar Nuevo Elemento</h3>
    </div>
    <div class="card-body">
        <form method="POST" class="timeline-form">
            <input type="hidden" name="action" value="add_item">
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Título *</label>
                    <input type="text" id="title" name="title" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="type">Tipo *</label>
                    <select id="type" name="type" required class="form-control">
                        <option value="">Seleccionar tipo</option>
                        <option value="eventos">Eventos</option>
                        <option value="proyectos">Proyectos</option>
                        <option value="publicaciones">Publicaciones</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description">Descripción *</label>
                    <textarea id="description" name="description" required class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="extended_content">Contenido Extendido</label>
                    <textarea id="extended_content" name="extended_content" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="date">Fecha *</label>
                    <input type="text" id="date" name="date" required class="form-control" 
                           placeholder="Ej: Marzo 2015, Noviembre 2016">
                </div>

                <div class="form-group">
                    <label for="image_url">URL de Imagen o Video de YouTube</label>
                    <input type="url" id="image_url" name="image_url" class="form-control" 
                           placeholder="https://example.com/image.jpg o https://youtube.com/watch?v=...">
                    <small class="form-text">Puedes usar URLs de imágenes, enlaces de YouTube, o subir archivos en la sección Medios</small>
                </div>

                <div class="form-group">
                    <label>O subir imagen desde archivo:</label>
                    <div class="upload-inline">
                        <input type="file" id="upload_image" accept="image/*" onchange="uploadImageAndFill()">
                        <button type="button" onclick="document.getElementById('upload_image').click()" class="btn btn-sm" style="margin-left: 10px;">📁 Seleccionar Imagen</button>
                    </div>
                    <small class="form-text">La imagen se subirá automáticamente y se llenará la URL</small>
                </div>

                <div class="form-group full-width">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_published" value="1" checked>
                            Publicar inmediatamente
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">➕ Agregar Elemento</button>
                <button type="reset" class="btn">🔄 Limpiar Formulario</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Elementos Existentes</h3>
    </div>
    <div class="card-body">
        <?php if (empty($timelineItems)): ?>
            <p class="no-items">No hay elementos en el timeline aún.</p>
        <?php else: ?>
            <div class="timeline-controls">
                <button onclick="toggleReorderMode()" class="btn btn-primary" id="reorder-btn">🔄 Reordenar Elementos</button>
                <button onclick="saveOrder()" class="btn btn-success" id="save-order-btn" style="display: none;">💾 Guardar Orden</button>
                <button onclick="cancelReorder()" class="btn" id="cancel-order-btn" style="display: none;">❌ Cancelar</button>
            </div>

            <div class="timeline-list" id="timeline-list">
                <?php foreach ($timelineItems as $item): ?>
                    <div class="timeline-admin-item" data-id="<?php echo $item['id']; ?>" data-order="<?php echo $item['sort_order']; ?>">
                        <div class="item-header">
                            <div class="drag-handle" style="display: none;">⠿</div>
                            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                            <div class="item-badges">
                                <span class="type-badge type-<?php echo $item['type']; ?>">
                                    <?php echo ucfirst($item['type']); ?>
                                </span>
                                <?php if ($item['is_published']): ?>
                                    <span class="status-badge published">Publicado</span>
                                <?php else: ?>
                                    <span class="status-badge draft">Borrador</span>
                                <?php endif; ?>
                                <span class="order-badge">Orden: <?php echo $item['sort_order']; ?></span>
                            </div>
                        </div>
                        
                        <div class="item-content">
                            <p class="item-date">📅 <?php echo htmlspecialchars($item['date']); ?></p>
                            <p class="item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                            
                            <?php if (!empty($item['image_url'])): ?>
                                <div class="item-media">
                                    <?php if (strpos($item['image_url'], 'youtube.com') !== false || strpos($item['image_url'], 'youtu.be') !== false): ?>
                                        <p>🎥 Video de YouTube: <a href="<?php echo htmlspecialchars($item['image_url']); ?>" target="_blank">Ver video</a></p>
                                    <?php else: ?>
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                             alt="Preview" class="media-preview">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="item-actions">
                            <button onclick="editItem(<?php echo $item['id']; ?>)" class="btn btn-sm">✏️ Editar</button>
                            <form method="POST" style="display: inline;" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este elemento?')">
                                <input type="hidden" name="action" value="delete_item">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Eliminar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
let isReorderMode = false;
let originalOrder = [];

function editItem(id) {
    // Simple edit functionality - you can expand this
    const newTitle = prompt('Nuevo título:');
    if (newTitle) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="edit_item">
            <input type="hidden" name="id" value="${id}">
            <input type="hidden" name="title" value="${newTitle}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function uploadImageAndFill() {
    const fileInput = document.getElementById('upload_image');
    const urlInput = document.getElementById('image_url');
    
    if (fileInput.files.length === 0) return;
    
    const formData = new FormData();
    formData.append('action', 'upload_media');
    formData.append('media_file', fileInput.files[0]);
    
    // Show loading
    urlInput.value = 'Subiendo imagen...';
    urlInput.disabled = true;
    
    formData.append('ajax', 'true');
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Get the filename from the success message
            const matches = data.message.match(/exitosamente: ([^\s]+)/);
            if (matches) {
                urlInput.value = window.location.origin + '/php/uploads/' + matches[1];
            } else {
                // Fallback: construct filename
                const timestamp = Date.now();
                const ext = fileInput.files[0].name.split('.').pop();
                urlInput.value = window.location.origin + '/php/uploads/' + timestamp + '.' + ext;
            }
            alert('Imagen subida exitosamente');
        } else {
            alert('Error: ' + data.message);
            urlInput.value = '';
        }
        urlInput.disabled = false;
        fileInput.value = '';
    })
    .catch(error => {
        alert('Error al subir imagen');
        urlInput.value = '';
        urlInput.disabled = false;
        fileInput.value = '';
    });
}

function toggleReorderMode() {
    isReorderMode = !isReorderMode;
    const items = document.querySelectorAll('.timeline-admin-item');
    const dragHandles = document.querySelectorAll('.drag-handle');
    const reorderBtn = document.getElementById('reorder-btn');
    const saveBtn = document.getElementById('save-order-btn');
    const cancelBtn = document.getElementById('cancel-order-btn');
    
    if (isReorderMode) {
        // Save original order
        originalOrder = Array.from(items).map(item => item.dataset.id);
        
        // Show drag handles and make items draggable
        dragHandles.forEach(handle => handle.style.display = 'block');
        items.forEach(item => {
            item.style.cursor = 'move';
            item.draggable = true;
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('drop', handleDrop);
        });
        
        reorderBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
        cancelBtn.style.display = 'inline-block';
        
        reorderBtn.textContent = '🔄 Reordenar Elementos';
    } else {
        cancelReorder();
    }
}

function cancelReorder() {
    isReorderMode = false;
    const items = document.querySelectorAll('.timeline-admin-item');
    const dragHandles = document.querySelectorAll('.drag-handle');
    const reorderBtn = document.getElementById('reorder-btn');
    const saveBtn = document.getElementById('save-order-btn');
    const cancelBtn = document.getElementById('cancel-order-btn');
    
    // Hide drag handles and remove draggable
    dragHandles.forEach(handle => handle.style.display = 'none');
    items.forEach(item => {
        item.style.cursor = 'default';
        item.draggable = false;
        item.removeEventListener('dragstart', handleDragStart);
        item.removeEventListener('dragover', handleDragOver);
        item.removeEventListener('drop', handleDrop);
    });
    
    reorderBtn.style.display = 'inline-block';
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
}

function saveOrder() {
    const items = document.querySelectorAll('.timeline-admin-item');
    const newOrder = Array.from(items).map(item => item.dataset.id);
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="reorder_items">
        <input type="hidden" name="items" value="${JSON.stringify(newOrder)}">
    `;
    document.body.appendChild(form);
    form.submit();
}

let draggedElement = null;

function handleDragStart(e) {
    draggedElement = this;
    e.dataTransfer.effectAllowed = 'move';
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
}

function handleDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    if (draggedElement !== this) {
        const container = document.getElementById('timeline-list');
        const allItems = Array.from(container.children);
        const draggedIndex = allItems.indexOf(draggedElement);
        const targetIndex = allItems.indexOf(this);
        
        if (draggedIndex < targetIndex) {
            container.insertBefore(draggedElement, this.nextSibling);
        } else {
            container.insertBefore(draggedElement, this);
        }
        
        // Update order badges
        updateOrderBadges();
    }
    
    return false;
}

function updateOrderBadges() {
    const items = document.querySelectorAll('.timeline-admin-item');
    items.forEach((item, index) => {
        const badge = item.querySelector('.order-badge');
        if (badge) {
            badge.textContent = `Orden: ${index + 1}`;
        }
    });
}
</script>

<style>
.timeline-form {
    max-width: 800px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group.full-width {
    grid-column: 1 / -1;
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

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.timeline-list {
    space-y: 20px;
}

.timeline-admin-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    background: white;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.item-header h4 {
    margin: 0;
    color: var(--primary-color);
    flex: 1;
}

.item-badges {
    display: flex;
    gap: 8px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: bold;
}

.status-badge.published {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.draft {
    background-color: #fff3cd;
    color: #856404;
}

.item-content {
    margin-bottom: 15px;
}

.item-date {
    color: var(--primary-color);
    font-weight: bold;
    margin-bottom: 8px;
}

.item-description {
    color: #666;
    margin-bottom: 10px;
}

.item-media {
    margin: 10px 0;
}

.media-preview {
    max-width: 200px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 4px;
}

.item-actions {
    display: flex;
    gap: 8px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.8rem;
}

.no-items {
    text-align: center;
    color: #666;
    padding: 40px;
}

.timeline-controls {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
}

.drag-handle {
    font-size: 18px;
    color: #666;
    cursor: grab;
    margin-right: 10px;
    user-select: none;
}

.drag-handle:active {
    cursor: grabbing;
}

.timeline-admin-item.dragging {
    opacity: 0.5;
}

.timeline-admin-item[draggable="true"] {
    border: 2px dashed #ddd;
    background: #f9f9f9;
}

.timeline-admin-item[draggable="true"]:hover {
    border-color: var(--primary-color);
}

.order-badge {
    background-color: #e9ecef;
    color: #495057;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.7rem;
    margin-left: 5px;
}

.upload-inline {
    display: flex;
    align-items: center;
    gap: 10px;
}

.upload-inline input[type="file"] {
    display: none;
}

@media screen and (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .item-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .form-actions,
    .item-actions {
        flex-direction: column;
    }
}
</style>