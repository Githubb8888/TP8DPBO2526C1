<?php
require_once __DIR__ . '/DB.php';

class Lecturer
{
    public function all(): array
    {
        return DB::conn()->query(
            "SELECT l.*, d.name AS department_name
             FROM lecturers l LEFT JOIN departments d ON d.id = l.department_id
             ORDER BY l.id"
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = DB::conn()->prepare("SELECT * FROM lecturers WHERE id = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(string $name, string $nidn, string $phone, string $joinDate, ?int $deptId): void
    {
        DB::conn()->prepare(
            "INSERT INTO lecturers (name, nidn, phone, join_date, department_id) VALUES (?, ?, ?, ?, ?)"
        )->execute([$name, $nidn, $phone, $joinDate, $deptId]);
    }

    public function update(int $id, string $name, string $nidn, string $phone, string $joinDate, ?int $deptId): void
    {
        DB::conn()->prepare(
            "UPDATE lecturers SET name = ?, nidn = ?, phone = ?, join_date = ?, department_id = ? WHERE id = ?"
        )->execute([$name, $nidn, $phone, $joinDate, $deptId, $id]);
    }

    public function delete(int $id): void
    {
        DB::conn()->prepare("DELETE FROM lecturers WHERE id = ?")->execute([$id]);
    }
}
