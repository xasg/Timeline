<?php
class TimelineModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllItems($filter = null) {
        $sql = "SELECT * FROM timeline_items WHERE is_published = 1";
        $params = [];

        if ($filter && $filter !== 'all' && in_array($filter, ['eventos', 'proyectos', 'publicaciones'])) {
            $sql .= " AND type = ?";
            $params[] = $filter;
        }

        $sql .= " ORDER BY sort_order ASC";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getItemById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM timeline_items WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function createItem($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO timeline_items (title, description, extended_content, date, type, image_url, is_published) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([
                $data['title'],
                $data['description'],
                $data['extended_content'],
                $data['date'],
                $data['type'],
                $data['image_url'],
                $data['is_published']
            ]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateItem($id, $data) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE timeline_items 
                SET title=?, description=?, extended_content=?, date=?, type=?, image_url=?, is_published=?, sort_order=?
                WHERE id=?
            ");
            return $stmt->execute([
                $data['title'],
                $data['description'],
                $data['extended_content'],
                $data['date'],
                $data['type'],
                $data['image_url'],
                $data['is_published'],
                $data['sort_order'] ?? 0,
                $id
            ]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateSortOrder($id, $sortOrder) {
        try {
            $stmt = $this->pdo->prepare("UPDATE timeline_items SET sort_order = ? WHERE id = ?");
            return $stmt->execute([$sortOrder, $id]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function reorderItems($items) {
        if (!is_array($items)) {
            error_log("TimelineModel::reorderItems received non-array input.");
            return false;
        }
        // If $items is empty, it's a success (nothing to do) or could be an error based on requirements.
        // For now, consider it a success.
        if (empty($items)) {
            return true;
        }

        try {
            $this->pdo->beginTransaction();
            // The controller now sends $items as a simple array of IDs [id1, id2, id3]
            // So, the $order should be $index + 1 as per typical sort_order.
            foreach ($items as $index => $id) {
                $itemId = (int) $id;
                if ($itemId <= 0) {
                    // Log or handle invalid item ID if necessary
                    continue;
                }
                $stmt = $this->pdo->prepare("UPDATE timeline_items SET sort_order = ? WHERE id = ?");
                // Assuming sort_order starts from 1
                $stmt->execute([$index + 1, $itemId]);
            }
            $this->pdo->commit();
            return true;
        } catch(PDOException $e) {
            $this->pdo->rollBack();
            error_log("Database error during reorderItems: " . $e->getMessage());
            return false;
        }
    }

    public function deleteItem($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM timeline_items WHERE id = ?");
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getStatsByType() {
        try {
            $stmt = $this->pdo->query("SELECT type, COUNT(*) as count FROM timeline_items GROUP BY type");
            $stats = [];
            while ($row = $stmt->fetch()) {
                $stats[$row['type']] = $row['count'];
            }
            return $stats;
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalCount() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM timeline_items");
            return $stmt->fetch()['total'];
        } catch(PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return 0;
        }
    }
}
?>