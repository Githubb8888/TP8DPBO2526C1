<?php
require_once __DIR__ . '/../models/Lecturer.php';
require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../views/LecturerView.php';

class LecturerController
{
    private Lecturer $model;
    private Department $departments;
    private LecturerView $view;

    public function __construct()
    {
        $this->model = new Lecturer();
        $this->departments = new Department();
        $this->view = new LecturerView();
    }

    public function index(): void  { $this->view->index($this->model->all()); }

    public function create(): void { $this->view->form(null, $this->departments->all()); }

    public function store(): void
    {
        $this->model->create(trim($_POST['name']), trim($_POST['nidn']), trim($_POST['phone']),
            $_POST['join_date'], $_POST['department_id'] !== '' ? (int)$_POST['department_id'] : null);
        header('Location: index.php?entity=lecturers'); exit;
    }

    public function edit(): void
    {
        $row = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$row) { header('Location: index.php?entity=lecturers'); exit; }
        $this->view->form($row, $this->departments->all());
    }

    public function update(): void
    {
        $this->model->update((int)$_POST['id'], trim($_POST['name']), trim($_POST['nidn']), trim($_POST['phone']),
            $_POST['join_date'], $_POST['department_id'] !== '' ? (int)$_POST['department_id'] : null);
        header('Location: index.php?entity=lecturers'); exit;
    }

    public function delete(): void
    {
        $this->model->delete((int)$_POST['id']);
        header('Location: index.php?entity=lecturers'); exit;
    }
}
