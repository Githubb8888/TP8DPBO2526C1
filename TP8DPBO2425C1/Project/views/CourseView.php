<?php
require_once __DIR__ . '/Template.php';

class CourseView
{
    public function index(array $rows): void
    {
        $e = 'Template::e';
        $body = '<div class="d-flex justify-content-between mb-3"><h2>Courses</h2>'
              . '<a class="btn btn-primary" href="index.php?entity=courses&action=create">Add New</a></div>'
              . '<table class="table table-striped"><thead><tr><th>ID</th><th>Code</th><th>Name</th>'
              . '<th>Credits</th><th>Lecturer</th><th>Actions</th></tr></thead><tbody>';
        foreach ($rows as $r) {
            $body .= '<tr><td>' . (int)$r['id'] . '</td><td>' . $e($r['code']) . '</td><td>' . $e($r['name'])
                  . '</td><td>' . (int)$r['credits'] . '</td><td>' . $e($r['lecturer_name'] ?? '-') . '</td><td>'
                  . "<a class='btn btn-success btn-sm' href='index.php?entity=courses&action=edit&id=" . (int)$r['id'] . "'>Edit</a> "
                  . Template::deleteForm('courses', (int)$r['id']) . '</td></tr>';
        }
        if (!$rows) $body .= '<tr><td colspan="6" class="text-center text-muted">Belum ada data</td></tr>';
        $body .= '</tbody></table>';
        Template::render('Courses', 'courses', $body);
    }

    public function form(?array $row, array $lecturers): void
    {
        $e = 'Template::e';
        $isEdit = $row !== null;
        $action = $isEdit ? 'update' : 'store';
        $body = '<div class="col-lg-6 m-auto"><div class="card"><div class="card-header '
              . ($isEdit ? 'bg-warning' : 'bg-primary') . '"><h3 class="text-white text-center mb-0">'
              . ($isEdit ? 'Update' : 'Create') . ' Course</h3></div><div class="card-body">'
              . "<form method='post' action='index.php?entity=courses&action=$action'>"
              . ($isEdit ? "<input type='hidden' name='id' value='" . (int)$row['id'] . "'>" : '')
              . '<label class="form-label">Code</label><input type="text" name="code" class="form-control mb-3" required value="' . $e($row['code'] ?? '') . '">'
              . '<label class="form-label">Name</label><input type="text" name="name" class="form-control mb-3" required value="' . $e($row['name'] ?? '') . '">'
              . '<label class="form-label">Credits (SKS)</label><input type="number" min="1" max="6" name="credits" class="form-control mb-3" required value="' . $e($row['credits'] ?? 3) . '">'
              . '<label class="form-label">Lecturer</label><select name="lecturer_id" class="form-select mb-3">'
              . Template::options($lecturers, 'name', $row['lecturer_id'] ?? '', '-- Belum ada pengajar --') . '</select>'
              . '<button class="btn btn-success" type="submit">Submit</button> '
              . '<a class="btn btn-info" href="index.php?entity=courses">Cancel</a>'
              . '</form></div></div></div>';
        Template::render(($isEdit ? 'Update' : 'Create') . ' Course', 'courses', $body);
    }
}
