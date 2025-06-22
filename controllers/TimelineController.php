<?php
require_once 'models/TimelineModel.php';
require_once 'models/MediaModel.php';
require_once 'models/ConfigModel.php';

class TimelineController {
    private $model;
    private $mediaModel;
    private $configModel;

    public function __construct($pdo) {
        $this->model = new TimelineModel($pdo);
        $this->mediaModel = new MediaModel($pdo);
        $this->configModel = new ConfigModel($pdo);
    }

    public function index() {
        $filter = $_GET['filter'] ?? 'all';
        $timelineItems = $this->model->getAllItems($filter);
        
        include 'views/timeline/index.php';
    }

    public function admin() {
        $view = $_GET['view'] ?? 'dashboard';
        $message = '';
        $error = '';

        // Handle form submissions
        if ($_POST) {
            $result = $this->handleAdminAction();
            if ($result['success']) {
                $message = $result['message'];
            } else {
                $error = $result['message'];
            }
        }

        // Handle AJAX upload requests
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
            header('Content-Type: application/json');
            echo json_encode($result ?? ['success' => false, 'message' => 'No action taken']);
            exit;
        }

        // Get data for different views
        switch ($view) {
            case 'dashboard':
                $stats = $this->model->getStatsByType();
                $totalItems = $this->model->getTotalCount();
                break;
            case 'timeline':
                $timelineItems = $this->model->getAllItems();
                break;
            case 'media':
                $mediaFiles = $this->mediaModel->getAllFiles();
                $mediaStats = $this->mediaModel->getFileStats();
                break;
            case 'settings':
                $settings = $this->configModel->getAllSettings();
                break;
        }

        include 'views/admin/index.php';
    }

    private function handleAdminAction() {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add_item':
                return $this->addItem();
            case 'edit_item':
                return $this->editItem();
            case 'delete_item':
                return $this->deleteItem();
            case 'upload_media':
                return $this->uploadMedia();
            case 'delete_media':
                return $this->deleteMedia();
            case 'save_settings':
                return $this->saveSettings();
            case 'reorder_items':
                return $this->reorderItems();
            default:
                return ['success' => false, 'message' => 'Acción no válida'];
        }
    }

    private function addItem() {
        $data = $this->validateItemData();
        if (!$data) {
            return ['success' => false, 'message' => 'Datos inválidos'];
        }

        if ($this->model->createItem($data)) {
            return ['success' => true, 'message' => 'Elemento agregado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al agregar elemento'];
        }
    }

    private function editItem() {
        $id = $_POST['id'] ?? 0;
        $data = $this->validateItemData();
        
        if (!$data || !$id) {
            return ['success' => false, 'message' => 'Datos inválidos'];
        }

        if ($this->model->updateItem($id, $data)) {
            return ['success' => true, 'message' => 'Elemento actualizado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar elemento'];
        }
    }

    private function deleteItem() {
        $id = $_POST['id'] ?? 0;
        
        if (!$id) {
            return ['success' => false, 'message' => 'ID inválido'];
        }

        if ($this->model->deleteItem($id)) {
            return ['success' => true, 'message' => 'Elemento eliminado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar elemento'];
        }
    }

    private function validateItemData() {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $extended_content = $_POST['extended_content'] ?? '';
        $date = $_POST['date'] ?? '';
        $type = $_POST['type'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        $is_published = isset($_POST['is_published']) ? 1 : 0;

        if (empty($title) || empty($description) || empty($date) || empty($type)) {
            return false;
        }

        if (!in_array($type, ['eventos', 'proyectos', 'publicaciones'])) {
            return false;
        }

        // Validate YouTube URL if provided
        if (!empty($image_url) && !$this->isValidUrl($image_url)) {
            return false;
        }

        return [
            'title' => $title,
            'description' => $description,
            'extended_content' => $extended_content,
            'date' => $date,
            'type' => $type,
            'image_url' => $image_url,
            'is_published' => $is_published
        ];
    }

    private function uploadMedia() {
        if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No se seleccionó archivo o hubo un error en la subida'];
        }

        $file = $_FILES['media_file'];
        $uploadDir = 'uploads/';
        
        // Create upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return ['success' => false, 'message' => 'No se pudo crear el directorio de subida'];
            }
        }

        // Check if directory is writable
        if (!is_writable($uploadDir)) {
            return ['success' => false, 'message' => 'El directorio de subida no tiene permisos de escritura'];
        }

        $allowedTypes = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
            'video/mp4', 'video/avi', 'video/mov', 'video/wmv',
            'application/pdf'
        ];
        
        if (!in_array(strtolower($file['type']), $allowedTypes)) {
            return ['success' => false, 'message' => 'Tipo de archivo no permitido: ' . $file['type']];
        }

        if ($file['size'] > 10 * 1024 * 1024) { // 10MB limit
            return ['success' => false, 'message' => 'Archivo demasiado grande (máximo 10MB)'];
        }

        // Generate unique filename
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $fileExtension;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $data = [
                'filename' => $filename,
                'original_name' => $file['name'],
                'file_path' => $filepath,
                'file_size' => $file['size'],
                'mime_type' => $file['type'],
                'file_type' => strpos($file['type'], 'image') === 0 ? 'image' : 
                             (strpos($file['type'], 'video') === 0 ? 'video' : 'document')
            ];

            if ($this->mediaModel->createFile($data)) {
                return ['success' => true, 'message' => 'Archivo subido exitosamente: ' . $filename];
            } else {
                // Clean up the uploaded file if database insert failed
                unlink($filepath);
                return ['success' => false, 'message' => 'Error al guardar información del archivo en la base de datos'];
            }
        }

        return ['success' => false, 'message' => 'Error al mover el archivo subido'];
    }

    private function deleteMedia() {
        $id = $_POST['media_id'] ?? 0;
        
        if (!$id) {
            return ['success' => false, 'message' => 'ID inválido'];
        }

        if ($this->mediaModel->deleteFile($id)) {
            return ['success' => true, 'message' => 'Archivo eliminado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar archivo'];
        }
    }

    private function saveSettings() {
        $settings = $_POST['settings'] ?? [];
        
        if (empty($settings)) {
            return ['success' => false, 'message' => 'No hay configuraciones para guardar'];
        }

        $success = true;
        foreach ($settings as $key => $value) {
            if (!$this->configModel->setSetting($key, $value)) {
                $success = false;
            }
        }

        if ($success) {
            return ['success' => true, 'message' => 'Configuración guardada exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar configuración'];
        }
    }

    private function isValidUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    private function reorderItems() {
        $items = $_POST['items'] ?? [];
        
        if (empty($items)) {
            return ['success' => false, 'message' => 'No hay elementos para reordenar'];
        }

        if ($this->model->reorderItems($items)) {
            return ['success' => true, 'message' => 'Elementos reordenados exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al reordenar elementos'];
        }
    }
}
?>