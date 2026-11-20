<?php

require_once __DIR__ . '/controllers/LecturerController.php';
require_once __DIR__ . '/controllers/DepartmentController.php';
require_once __DIR__ . '/controllers/CourseController.php';

$entity = $_GET['entity'] ?? 'lecturers';
$action = $_GET['action'] ?? 'index';

$controllers = [
    'lecturers'   => 'LecturerController',
    'departments' => 'DepartmentController',
    'courses'     => 'CourseController',
];
$allowed = ['index', 'create', 'store', 'edit', 'update', 'delete'];

if (!isset($controllers[$entity]) || !in_array($action, $allowed, true)) {
    http_response_code(404);
    exit('Halaman tidak ditemukan');
}

if (in_array($action, ['store', 'update', 'delete'], true) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$controller = new $controllers[$entity]();
$controller->$action();
