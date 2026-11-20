<?php
require_once __DIR__ . '/DB.php';

class Department
{
    public function all(): array
    {
        return DB::conn()->query(
            "SELECT d.*, COUNT(l.id) AS total_lecturers
             FROM departments d LEFT JOIN lecturers l ON l.department_id = d.id
             GROUP BY d.id ORDER BY d.id"
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = DB::conn()->prepare("SELECT * FROM departments WHERE id = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(string $name, string $faculty): void
    {
        DB::conn()->prepare("INSERT INTO departments (name, faculty) VALUES (?, ?)")
            ->execute([$name, $faculty]);
    }

    public function update(int $id, string $name, string $faculty): void
    {
        DB::conn()->prepare("UPDATE departments SET name = ?, faculty = ? WHERE id = ?")
            ->execute([$name, $faculty, $id]);
    }

    public function delete(int $id): void
    {
        DB::conn()->prepare("DELETE FROM departments WHERE id = ?")->execute([$id]);
    }
}
