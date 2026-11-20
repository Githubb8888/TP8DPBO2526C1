<?php
require_once __DIR__ . '/DB.php';

class Course
{
    public function all(): array
    {
        return DB::conn()->query(
            "SELECT c.*, l.name AS lecturer_name
             FROM courses c LEFT JOIN lecturers l ON l.id = c.lecturer_id
             ORDER BY c.id"
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = DB::conn()->prepare("SELECT * FROM courses WHERE id = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(string $code, string $name, int $credits, ?int $lecturerId): void
    {
        DB::conn()->prepare(
            "INSERT INTO courses (code, name, credits, lecturer_id) VALUES (?, ?, ?, ?)"
        )->execute([$code, $name, $credits, $lecturerId]);
    }

    public function update(int $id, string $code, string $name, int $credits, ?int $lecturerId): void
    {
        DB::conn()->prepare(
            "UPDATE courses SET code = ?, name = ?, credits = ?, lecturer_id = ? WHERE id = ?"
        )->execute([$code, $name, $credits, $lecturerId, $id]);
    }

    public function delete(int $id): void
    {
        DB::conn()->prepare("DELETE FROM courses WHERE id = ?")->execute([$id]);
    }
}
