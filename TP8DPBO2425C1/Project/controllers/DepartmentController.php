<?php
require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../views/DepartmentView.php';

class DepartmentController
{
    private Department $model;
    private DepartmentView $view;

    public function __construct()
    {
        $this->model = new Department();
        $this->view = new DepartmentView();
    }

    public function index(): void  { $this->view->index($this->model->all()); }

    public function create(): void { $this->view->form(null); }

    public function store(): void
    {
        $this->model->create(trim($_POST['name']), trim($_POST['faculty']));
        header('Location: index.php?entity=departments'); exit;
    }

    public function edit(): void
    {
        $row = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$row) { header('Location: index.php?entity=departments'); exit; }
        $this->view->form($row);
    }

    public function update(): void
    {
        $this->model->update((int)$_POST['id'], trim($_POST['name']), trim($_POST['faculty']));
        header('Location: index.php?entity=departments'); exit;
    }

    public function delete(): void
    {
        $this->model->delete((int)$_POST['id']);
        header('Location: index.php?entity=departments'); exit;
    }
}
