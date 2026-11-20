<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lecturer.php';
require_once __DIR__ . '/../views/CourseView.php';

class CourseController
{
    private Course $model;
    private Lecturer $lecturers;
    private CourseView $view;

    public function __construct()
    {
        $this->model = new Course();
        $this->lecturers = new Lecturer();
        $this->view = new CourseView();
    }

    public function index(): void  { $this->view->index($this->model->all()); }

    public function create(): void { $this->view->form(null, $this->lecturers->all()); }

    public function store(): void
    {
        $this->model->create(trim($_POST['code']), trim($_POST['name']), (int)$_POST['credits'],
            $_POST['lecturer_id'] !== '' ? (int)$_POST['lecturer_id'] : null);
        header('Location: index.php?entity=courses'); exit;
    }

    public function edit(): void
    {
        $row = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$row) { header('Location: index.php?entity=courses'); exit; }
        $this->view->form($row, $this->lecturers->all());
    }

    public function update(): void
    {
        $this->model->update((int)$_POST['id'], trim($_POST['code']), trim($_POST['name']), (int)$_POST['credits'],
            $_POST['lecturer_id'] !== '' ? (int)$_POST['lecturer_id'] : null);
        header('Location: index.php?entity=courses'); exit;
    }

    public function delete(): void
    {
        $this->model->delete((int)$_POST['id']);
        header('Location: index.php?entity=courses'); exit;
    }
}
