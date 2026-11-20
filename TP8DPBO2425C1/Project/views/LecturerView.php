<?php
require_once __DIR__ . '/Template.php';

class LecturerView
{
    public function index(array $rows): void
    {
        $e = 'Template::e';
        $body = '<div class="d-flex justify-content-between mb-3"><h2>Lecturers</h2>'
              . '<a class="btn btn-primary" href="index.php?entity=lecturers&action=create">Add New</a></div>'
              . '<table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>NIDN</th>'
              . '<th>Phone</th><th>Join Date</th><th>Department</th><th>Actions</th></tr></thead><tbody>';
        foreach ($rows as $r) {
            $body .= '<tr><td>' . (int)$r['id'] . '</td><td>' . $e($r['name']) . '</td><td>' . $e($r['nidn'])
                  . '</td><td>' . $e($r['phone']) . '</td><td>' . $e($r['join_date'])
                  . '</td><td>' . $e($r['department_name'] ?? '-') . '</td><td>'
                  . "<a class='btn btn-success btn-sm' href='index.php?entity=lecturers&action=edit&id=" . (int)$r['id'] . "'>Edit</a> "
                  . Template::deleteForm('lecturers', (int)$r['id']) . '</td></tr>';
        }
        if (!$rows) $body .= '<tr><td colspan="7" class="text-center text-muted">Belum ada data</td></tr>';
        $body .= '</tbody></table>';
        Template::render('Lecturers', 'lecturers', $body);
    }

    public function form(?array $row, array $departments): void
    {
        $e = 'Template::e';
        $isEdit = $row !== null;
        $action = $isEdit ? 'update' : 'store';
        $body = '<div class="col-lg-6 m-auto"><div class="card"><div class="card-header '
              . ($isEdit ? 'bg-warning' : 'bg-primary') . '"><h3 class="text-white text-center mb-0">'
              . ($isEdit ? 'Update' : 'Create') . ' Lecturer</h3></div><div class="card-body">'
              . "<form method='post' action='index.php?entity=lecturers&action=$action'>"
              . ($isEdit ? "<input type='hidden' name='id' value='" . (int)$row['id'] . "'>" : '')
              . '<label class="form-label">Name</label><input type="text" name="name" class="form-control mb-3" required value="' . $e($row['name'] ?? '') . '">'
              . '<label class="form-label">NIDN</label><input type="text" name="nidn" class="form-control mb-3" required value="' . $e($row['nidn'] ?? '') . '">'
              . '<label class="form-label">Phone</label><input type="text" name="phone" class="form-control mb-3" required value="' . $e($row['phone'] ?? '') . '">'
              . '<label class="form-label">Join Date</label><input type="date" name="join_date" class="form-control mb-3" required value="' . $e($row['join_date'] ?? '') . '">'
              . '<label class="form-label">Department</label><select name="department_id" class="form-select mb-3">'
              . Template::options($departments, 'name', $row['department_id'] ?? '', '-- Tanpa Department --') . '</select>'
              . '<button class="btn btn-success" type="submit">Submit</button> '
              . '<a class="btn btn-info" href="index.php?entity=lecturers">Cancel</a>'
              . '</form></div></div></div>';
        Template::render(($isEdit ? 'Update' : 'Create') . ' Lecturer', 'lecturers', $body);
    }
}
