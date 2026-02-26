<?php

class Category extends BaseModel
{
    protected $table = 'categories';

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllPaginated($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchColumn();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create($name, $slug)
    {
        $sql = "INSERT INTO {$this->table} (name, slug) VALUES (:name, :slug)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            ':slug' => htmlspecialchars($slug, ENT_QUOTES, 'UTF-8')
        ]);
    }

    public function update($id, $name, $slug)
    {
        $sql = "UPDATE {$this->table} SET name = :name, slug = :slug WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            ':slug' => htmlspecialchars($slug, ENT_QUOTES, 'UTF-8')
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
