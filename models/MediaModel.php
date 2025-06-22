<?php
class MediaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllFiles() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM media_files ORDER BY uploaded_at DESC");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getFileById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM media_files WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function createFile($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO media_files (filename, original_name, file_path, file_size, mime_type, file_type) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([
                $data['filename'],
                $data['original_name'],
                $data['file_path'],
                $data['file_size'],
                $data['mime_type'],
                $data['file_type']
            ]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFile($id) {
        try {
            // Get file info first
            $file = $this->getFileById($id);
            if ($file) {
                // Delete physical file
                if (file_exists($file['file_path'])) {
                    unlink($file['file_path']);
                }
                
                // Delete from database
                $stmt = $this->pdo->prepare("DELETE FROM media_files WHERE id = ?");
                return $stmt->execute([$id]);
            }
            return false;
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getFileStats() {
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    COUNT(*) as total_files,
                    SUM(file_size) as total_size,
                    COUNT(CASE WHEN file_type = 'image' THEN 1 END) as images,
                    COUNT(CASE WHEN file_type = 'video' THEN 1 END) as videos,
                    COUNT(CASE WHEN file_type = 'document' THEN 1 END) as documents
                FROM media_files
            ");
            return $stmt->fetch();
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
?>