<?php
$pageTitle = '10 AÑOS ANUIES TIC';
$pageDescription = 'Una década de innovación y colaboración en la educación superior mexicana - Comité ANUIES TIC';
$showAdminBtn = true;
include 'views/layouts/header.php';
?>

<div class="filters">
    <a href="?filter=all" class="filter-btn <?php echo ($filter ?? 'all') === 'all' ? 'active' : ''; ?>">Todos</a>
    <a href="?filter=eventos" class="filter-btn <?php echo ($filter ?? '') === 'eventos' ? 'active' : ''; ?>">Eventos</a>
    <a href="?filter=proyectos" class="filter-btn <?php echo ($filter ?? '') === 'proyectos' ? 'active' : ''; ?>">Proyectos</a>
    <a href="?filter=publicaciones" class="filter-btn <?php echo ($filter ?? '') === 'publicaciones' ? 'active' : ''; ?>">Publicaciones</a>
</div>

<div class="timeline-container">
    <div class="timeline-line"></div>

    <?php if (empty($timelineItems)): ?>
        <div class="no-items">
            <h3>No hay elementos disponibles</h3>
            <p>No se encontraron elementos en esta categoría.</p>
        </div>
    <?php else: ?>
        <?php foreach ($timelineItems as $index => $item): ?>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date"><?php echo htmlspecialchars($item['date']); ?></div>
                <div class="timeline-content">
                    <h2>
                        <?php echo htmlspecialchars($item['title']); ?>
                        <span class="type-badge type-<?php echo $item['type']; ?>">
                            <?php echo ucfirst($item['type']); ?>
                        </span>
                    </h2>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    
                    <?php if (!empty($item['image_url'])): ?>
                        <div style="margin: 15px 0; border-radius: 6px; overflow: hidden;">
                            <?php if (strpos($item['image_url'], 'youtube.com') !== false || strpos($item['image_url'], 'youtu.be') !== false): ?>
                                <?php
                                // Extract YouTube video ID
                                $videoId = '';
                                if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $item['image_url'], $matches)) {
                                    $videoId = $matches[1];
                                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $item['image_url'], $matches)) {
                                    $videoId = $matches[1];
                                }
                                ?>
                                <?php if ($videoId): ?>
                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                        <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                                frameborder="0" allowfullscreen></iframe>
                                    </div>
                                <?php else: ?>
                                    <p><a href="<?php echo htmlspecialchars($item['image_url']); ?>" target="_blank">🎥 Ver video en YouTube</a></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>"
                                     style="width: 100%; height: auto; display: block;"
                                     onerror="this.style.display='none';">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($item['extended_content'])): ?>
                        <button class="expand-button" onclick="toggleContent(<?php echo $item['id']; ?>)">
                            Leer más
                        </button>
                        <div class="hidden-content" id="content-<?php echo $item['id']; ?>">
                            <p><?php echo htmlspecialchars($item['extended_content']); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="timeline-share-buttons">
                        <button class="share-btn x-share-btn" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-url="<?php echo htmlspecialchars("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>"><img src="assets/images/x_logo.png" alt="X"></button>
                        <button class="share-btn facebook-share-btn" data-url="<?php echo htmlspecialchars("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>"><img src="assets/images/facebook_logo.png" alt="Facebook"></button>
                        <button class="share-btn whatsapp-share-btn" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-url="<?php echo htmlspecialchars("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>"><img src="assets/images/whatsapp_logo.png" alt="WhatsApp"></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'views/layouts/footer.php'; ?>