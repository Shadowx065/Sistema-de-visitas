<?php
require_once __DIR__ . '/Visit.php';
require_once __DIR__ . '/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    redirectWithMessage('index.php', 'warning', 'ID inválido.');
}

$database = new Database();
$visitModel = new Visit($database->connect());

if ($visitModel->delete($id)) {
    redirectWithMessage('index.php', 'success', 'Registro eliminado correctamente.');
}

redirectWithMessage('index.php', 'danger', 'No se pudo eliminar el registro.');
