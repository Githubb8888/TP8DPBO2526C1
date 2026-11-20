<?php
require_once __DIR__ . '/Template.php';

class DepartmentView
{
    public function index(array $rows): void
    {
        $e = 'Template::e';
        $body = '<div class="d-flex justify-content-between mb-3"><h2>Departments</h2>'
              . '<a class="btn btn-primary" href="index.php?entity=departments&action=create">Add New</a></div>'
              . '<table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Faculty</th>'
              . '<th>Total Lecturers</th><th>Actions</th></tr></thead><tbody>';
        foreach ($rows as $r) {
            $body .= '<tr><td>' . (int)$r['id'] . '</td><td>' . $e($r['name']) . '</td><td>' . $e($r['faculty'])
                  . '</td><td>' . (int)$r['total_lecturers'] . '</td><td>'
                  . "<a class='btn btn-success btn-sm' href='index.php?entity=departments&action=edit&id=" . (int)$r['id'] . "'>Edit</a> "
                  . Template::deleteForm('departments', (int)$r['id']) . '</td></tr>';
        }
        if (!$rows) $body .= '<tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>';
        $body .= '</tbody></table>';
        Template::render('Departments', 'departments', $body);
    }

    public function form(?array $row): void
    {
        $e = 'Template::e';
        $isEdit = $row !== null;
        $action = $isEdit ? 'update' : 'store';
        $body = '<div class="col-lg-6 m-auto"><div class="card"><div class="card-header '
              . ($isEdit ? 'bg-warning' : 'bg-primary') . '"><h3 class="text-white text-center mb-0">'
              . ($isEdit ? 'Update' : 'Create') . ' Department</h3></div><div class="card-body">'
              . "<form method='post' action='index.php?entity=departments&action=$action'>"
              . ($isEdit ? "<input type='hidden' name='id' value='" . (int)$row['id'] . "'>" : '')
              . '<label class="form-label">Name</label><input type="text" name="name" class="form-control mb-3" required value="' . $e($row['name'] ?? '') . '">'
              . '<label class="form-label">Faculty</label><input type="text" name="faculty" class="form-control mb-3" required value="' . $e($row['faculty'] ?? '') . '">'
              . '<button class="btn btn-success" type="submit">Submit</button> '
              . '<a class="btn btn-info" href="index.php?entity=departments">Cancel</a>'
              . '</form></div></div></div>';
        Template::render(($isEdit ? 'Update' : 'Create') . ' Department', 'departments', $body);
    }
}
