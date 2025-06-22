<?php
class ConfigModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSettings() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM settings ORDER BY setting_key");
            $settings = [];
            while ($row = $stmt->fetch()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            return $settings;
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getSetting($key) {
        try {
            $stmt = $this->pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
            $stmt->execute([$key]);
            $result = $stmt->fetch();
            return $result ? $result['setting_value'] : null;
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function setSetting($key, $value) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO settings (setting_key, setting_value) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
            ");
            return $stmt->execute([$key, $value]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteSettings($keys) {
        try {
            $placeholders = str_repeat('?,', count($keys) - 1) . '?';
            $stmt = $this->pdo->prepare("DELETE FROM settings WHERE setting_key IN ($placeholders)");
            return $stmt->execute($keys);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
?>